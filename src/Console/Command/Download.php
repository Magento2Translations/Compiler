<?php
namespace M2t\Console\Command;

use GuzzleHttp\Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use M2t\Data\Branches;
use M2t\Data\Language;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

//use GuzzleHttp\Promise;


class Download extends Command
{
    protected $progressBar     = null;
    protected $translationsDir = null;
    protected $languages       = [];
    protected $branches        = [];

    protected function configure()
    {
        $this->setName('download')
            ->setDescription('Download crowdin translations')
            ->addArgument('lang', InputArgument::IS_ARRAY, 'What Language(s) need to be downloaded?')
            ->addOption('branch', 'b', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'What branch(es) need to be downloaded?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->languages = Language::languageCodes();
        $this->branches  = Branches::branches();

        //Branch
        $branchChoice = $input->getOption('branch');
        if ($branchChoice) {
            foreach ($branchChoice as $key => $inputBranch) {
                $branchChoice[$key] = $inputBranch;
                if (!in_array($branchChoice[$key], $this->branches)) {
                    $output->writeln('<error>Branch not valid ' . $inputBranch . '</error>');
                    unset($branchChoice[$key]);
                }
            }
            if (count(array_values($branchChoice)) <= 0) {
                $output->writeln('<error>No valid branch found in your --branch input, exiting!</error>');
                exit(1);
            }
            $this->branches = array_values($branchChoice);
        }

        //check arguments
        //Lang
        $langChoice = $input->getArgument('lang');
        if ($langChoice) {
            foreach ($langChoice as $key => $inputLang) {
                $langChoice[$key] = $inputLang;
                if (!in_array($langChoice[$key], $this->languages)) {
                    $output->writeln('<comment>Input not found ' . $inputLang . '</comment>');
                    unset($langChoice[$key]);
                }
            }
            $langChoice = array_values($langChoice);
        }

        // ask question
        if (!$langChoice || count($langChoice) < 1) {
            $helper   = $this->getHelper('question');
            $question = new ChoiceQuestion('What Language do you want to download?', $this->languages, 0);
            $question->setMultiselect(true);
            $question->setErrorMessage('Input %s is invalid.');

            $langChoice = $helper->ask($input, $output, $question);
        }

        if (in_array('all', $langChoice)) {
            unset($this->languages[0]);
            $langChoice = array_values($this->languages);
        }


        $output->writeln('<info></info>');
        $output->writeln('<info></info>');
        $output->writeln('<info>Download translations ' . implode(', ', $langChoice) . ' for ' . implode(', ', $this->branches) . '</info>');

        //$this->progressBar = new ProgressBar($output, 100);
        $client = new Client([
            'base_uri' => 'http://107.170.242.99/'
        ]);

        foreach ($this->branches as $branch) {
            if (null == $this->translationsDir) {
                $this->translationsDir = new Filesystem(new Local(DOWNLOADS_DIR));
            }
            $this->translationsDir->createDir($branch);

            $output->writeln('<info></info>');
            $output->writeln('<info></info>');
            $output->writeln('<info>Switch branch ' . $branch . '</info>');
            foreach ($langChoice as $lang) {
                $this->progressBar = new ProgressBar($output, 100);
                $output->writeln('<info> Download ' . $lang . ' start</info>');
                $this->progressBar->start();
                $client->request('GET', '/var/' . ucwords(strtolower($branch)) . '/source_' . $lang . '.csv', ['sink' => DOWNLOADS_DIR . DIRECTORY_SEPARATOR . $branch . DIRECTORY_SEPARATOR . $lang . '.csv']);
                $this->progressBar->finish();
                $output->writeln('<info></info>');
                $output->writeln('<info> Download ' . $lang . ' completed</info>');
            }
        }
    }

    protected function progress($dl_total_size, $dl_size_so_far, $ul_total_size, $ul_size_so_far)
    {
        if ($dl_total_size > $dl_size_so_far && intval($dl_size_so_far) != 0) {
            $this->progressBar->setProgress(intval(round((intval($dl_size_so_far) / intval($dl_total_size)) * 100)));
        }
    }
}
