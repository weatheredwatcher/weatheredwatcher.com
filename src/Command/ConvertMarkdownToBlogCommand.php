<?php

namespace App\Command;

use App\Entity\Blog as EntityBlog;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Mni\FrontYAML\Parser;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Carbon\Carbon;



class ConvertMarkdownToBlogCommand extends Command
{
     // the name of the command (the part after "bin/console")
     protected static $defaultName = 'app:convert-blog';

     private $manager;

     public function __construct(EntityManager $manager)
     {
      $this->manager = $manager;  
      parent::__construct(); 
     }
     protected function configure()
     {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Import Markdown Files, like from Hugo or Jekyl.')

        // the full command description shown when running the command with
       // the "--help" option
        ->setHelp('This command allows you to import markdown files into the blog...')
    ;
     }
 
     protected function execute(InputInterface $input, OutputInterface $output)
     {
        
        $path = "/home/weatheredwatcher/Sites/weatheredwatcher.netlify.com/content/posts";
        $finder = new Finder();
        $parser = new Parser();
        $finder->files()->in($path);
        
        foreach ($finder as $file) {
            $title    = $file->getFilename();
            $contents = $file->getContents();
            $document = $parser->parse($contents,false);
            $yaml = $document->getYAML();
            $text = $document->getContent();
            $entry = new EntityBlog();
            $created = new Carbon($yaml['date']);
            $entry->setTitle($yaml['title']);
            $entry->setContent($text);
            $entry->setCreated($created);
    
            $this->manager->persist($entry);
        }
         $this->manager->flush();
         return Command::SUCCESS;
         // or return this if some error happened during the execution
         // (it's equivalent to returning int(1))
         // return Command::FAILURE;
     }

}