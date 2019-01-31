<?php
namespace modinst\forms;

use std, gui, framework, windows, modinst;


class MainForm extends AbstractForm
{

    /**
     * @event browseButton.action 
     */
    function doBrowseButtonAction(UXEvent $e = null)
    {    
        $this->dirChooser->execute();
    }

    /**
     * @event installButton.action 
     */
    function doInstallButtonAction(UXEvent $e = null)
    {    
        if($this->gamepath->text == "") {
            $this->statusText->text = "Укажите путь к игре";
            return false;
        }
        
        $this->installButton->enabled = false;
        $this->statusText->text = "Загрузка файлов...";
        $this->progressBar->progress = 0;
        
        $tmpdir = Windows::getTemp()."\\modaidinsttmp";
    
        if($this->moonloaderCheck->selected == true) {
            array_push($this->downloader->urls, "https://pinig.in/modaid/installer/moonloaderclean.zip");
        }
        
        array_push($this->downloader->urls, "https://pinig.in/modaid/installer/dependencies.zip");
        
        if($this->installUpdaterCheck->selected == true) {
            array_push($this->downloader->urls, "https://pinig.in/modaid/build/mod-aid-updater.luac");
        }
        
        array_push($this->downloader->urls, "https://pinig.in/modaid/build/mod-aid.luac");
        
        mkdir($tmpdir);
        
        $this->downloader->destDirectory = $tmpdir;
        
        $this->downloader->start();
    }

}
