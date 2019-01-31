<?php
namespace modinst\modules;

use php\compress\ZipFile;
use windows;
use std, gui, framework, modinst;


class MainModule extends AbstractModule
{

    /**
     * @event dirChooser.action 
     */
    function doDirChooserAction(ScriptEvent $e = null)
    {    
        $this->gamepath->text = $this->dirChooser->file->getPath();
    }

    /**
     * @event downloader.successAll 
     */
    function doDownloaderSuccessAll(ScriptEvent $e = null)
    {    
        $this->statusText->text = "Установка...";
    
        $tmpdir = Windows::getTemp()."\\modaidinsttmp";
        if($this->moonloaderCheck->selected == true) {
            $zipFile = new ZipFile($tmpdir."\\moonloaderclean.zip");
            $zipFile->unpack($this->gamepath->text);
            fs::delete($tmpdir."\\moonloaderclean.zip");
        }
        
        $zipFile = new ZipFile($tmpdir."\\dependencies.zip");
        $zipFile->unpack($this->gamepath->text);
        fs::delete($tmpdir."\\dependencies.zip");
        
        if($this->installUpdaterCheck->selected == true) {
            fs::move($tmpdir."\\mod-aid-updater.luac", $this->gamepath->text."\\moonloader\\mod-aid-updater.luac");
        }
        
        fs::move($tmpdir."\\mod-aid.luac", $this->gamepath->text."\\moonloader\\mod-aid.luac");
        
        $this->statusText->text = "Установка завершена";
        //$this->progressBar->progress = 0;
        $this->installButton->enabled = true;
        
        fs::delete($tmpdir);
        
    }



    /**
     * @event downloader.successOne 
     */
    function doDownloaderSuccessOne(ScriptEvent $e = null)
    {    
        $count = count($this->downloader->urls);
        $one = 100;
        switch($count) {
            case 2:
                $one = 50;
                break;
            case 3:
                $one = 33.333333333333336;
                break;
            case 4:
                $one = 25;
                break;
        }
        $this->progressBar->progress += $one;
    }

}
