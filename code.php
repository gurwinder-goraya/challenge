<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// Function to parse CSV file and return data as array
function parseCsvFile($filename)
{
    $servicesByCountry = [];

    // Open the CSV file
    if (($handle = fopen($filename, 'r')) !== false) {
        // Skip the first row (header)
        fgetcsv($handle);

        // Read data from CSV file
        while (($data = fgetcsv($handle)) !== false) {
            // Extract service and country code
            $service = $data[2];
            $countryCode = strtoupper($data[3]);

            // Create country entry if not exists
            if (!isset($servicesByCountry[$countryCode])) {
                $servicesByCountry[$countryCode] = [];
            }

            // Add service to country's list of services
            $servicesByCountry[$countryCode][] = $service;
        }

        // Close the CSV file
        fclose($handle);
    }

    return $servicesByCountry;
}

// Create a new CLI application
$application = new Application();

// Define a command to query services by country code
$application->register('query')
    ->addArgument('country-code', InputArgument::REQUIRED, 'Country code to query services for')
    ->setDescription('Query services by country code')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        // Get the provided country code
        $countryCode = strtoupper($input->getArgument('country-code'));

        // Parse the CSV file to get services by country
        $servicesByCountry = parseCsvFile('services.csv');

        // Check if services exist for the provided country code
        if (isset($servicesByCountry[$countryCode])) {
            // Display the services for the country code
            $services = $servicesByCountry[$countryCode];
            $io = new SymfonyStyle($input, $output);
            $io->title('Services for ' . $countryCode);
            foreach ($services as $service) {
                $io->writeln($service);
            }
        } else {
            // If no services found for the provided country code
            $output->writeln("<error>No services found for country code '$countryCode'.</error>");
        }
    });

// Define a command to display summary of services by country
$application->register('summary')
    ->setDescription('Display summary of services by country')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        // Parse the CSV file to get services by country
        $servicesByCountry = parseCsvFile('services.csv');

        // Display summary of services by country
        $io = new SymfonyStyle($input, $output);
        $io->title('Summary of Services by Country');
        foreach ($servicesByCountry as $countryCode => $services) {
            $io->section("Country: $countryCode");
            $io->writeln("Total services: " . count($services));
        }
    });

// Run the CLI application
$application->run();
