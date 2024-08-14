<?php

namespace App\Command;

use App\Service\DataValidator;
use App\Service\PaymentService;
use GuzzleHttp\Exception\RequestException;
use Shift4\Exception\Shift4Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsCommand(name: 'app:payment', description: 'Complete payment using payment gateways',)]
class PaymentCommand extends Command
{
    public function __construct(private readonly PaymentService $paymentService, private readonly DataValidator $dataValidator)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to complete your payment using shift4/aci.')
            ->addArgument('paymentType', InputArgument::REQUIRED, 'Payment Type (only shift4 or aci)')
            ->addArgument('paymentData', InputArgument::IS_ARRAY|InputArgument::REQUIRED, 'pass details about your payment such as amount, currency, card details (number, exp year, exp month, cvv)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $paymentType = $input->getArgument('paymentType');
            $paymentData = $input->getArgument('paymentData');

            $processedData = [];
            foreach ($paymentData as $data) {
                list($name, $value) = explode(':', $data);
                $processedData[$name] = $value;
            }

            $result = $this->paymentService->processPayment($paymentType, $processedData);
            $output->writeln(print_r($result, true));
            return Command::SUCCESS;
        } catch (ValidationFailedException $exc) {
            $errors = $this->dataValidator->processErrors($exc->getViolations());
            $io->error(json_encode($errors, JSON_PRETTY_PRINT));
            return Command::INVALID;
        } catch (NotFoundHttpException|RequestException $exc) {
            $io->error($exc->getMessage());
            return Command::INVALID;
        } catch (Shift4Exception $exc) {
            $io->error("Wrong parameter passed, please check payment information");
            return Command::INVALID;
        }
    }
}
