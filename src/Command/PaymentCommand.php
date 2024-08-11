<?php

namespace App\Command;

use App\Factory\PaymentMethodFactory;
use App\Service\PaymentService;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:payment', description: 'Complete payment using payment gateways',)]
class PaymentCommand extends Command
{
    public function __construct(private PaymentService $paymentService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to complete your payment using shift4/aci.') // should write more details about arguments & how to use
            ->addArgument('paymentType', InputArgument::REQUIRED, 'Payment Type (shift4 or aci)')
            ->addArgument('paymentData', InputArgument::IS_ARRAY|InputArgument::REQUIRED, 'pass details about your payment such as amount, currency, card details (number, exp year, exp month, cvv)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $output->writeln($input->getArgument('paymentType') . ' is selected');
            $paymentType = $input->getArgument('paymentType');
            $paymentData = $input->getArgument('paymentData');

            $processedData = [];
            foreach ($paymentData as $data) {
                list($name, $value) = explode(':', $data);
                $processedData[$name] = $value;
            }

            $result = $this->paymentService->processPayment($paymentType, $processedData);
            $output->writeln("amount: " . $result['amount']);
            $output->writeln("amount: " . $result['currency']);
            return Command::SUCCESS;
        } catch (RequestException $exc) {
            $errorDetails = json_decode($exc->getResponse()->getBody()->getContents(), true);

            // should use adapter for managing different payment errors
            $output->writeln($errorDetails['result']['description']);
            return Command::INVALID;
        }
    }
}
