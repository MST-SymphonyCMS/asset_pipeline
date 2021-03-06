<?php

require_once TOOLKIT . '/class.administrationpage.php';
//require_once EXTENSIONS . '/asset_pipeline/lib/defines.php';

use asset_pipeline\AP;

class contentExtensionAsset_pipelinePrecompile_assets extends AdministrationPage
{
    public function __construct()
    {
        parent::__construct();
        $_GET['symphony-page'] = '/system/precompile-assets/';
    }

    public function __viewIndex()
    {
        $this->setPageType('table');
        $this->addScriptToHead(URL . '/extensions/asset_pipeline/assets/precompile-assets.js', 400, false);

        $this->setTitle(__('%1$s &ndash; %2$s', array(__('Precompile Assets'), __('Symphony'))));

        $view = new XMLElement(
            'div',
            Widget::Label(__('View'), null, 'apply-label-left'),
            array('class' => 'apply actions')
        );

        $this->appendSubheading(
            __('Precompile Assets')
        );

        $fieldset = new XMLElement(
            'fieldset',
            null,
            array('id' => 'file-adder', 'style' => 'margin: 8px 18px 0 18px;')
        );

        $source_directories = is_file(AP\SOURCE_DIRECTORIES) ? include AP\SOURCE_DIRECTORIES : null;
        $options = array();
        if (is_array($source_directories)) {
            foreach ($source_directories as $path => $directory) {
                $options[] = array($path, true, $directory['name']);
            }
        }
        $fieldset->appendChild(
            Widget::Label(
                __('Asset Directories'),
                Widget::Select('items[]', $options, array('id' => 'files-available', 'multiple' => 'multiple')),
                null
            )
        );
        $fieldset->appendChild(
            new XMLElement(
                'button',
                __('Compile'),
                array('id' => 'add-files', 'class' => 'button', 'type' => 'submit')
            )
        );
        $this->Form->appendChild($fieldset);
        $this->Form->appendChild(
            new XMLElement(
                'div',
                null,
                array('id' => 'compilation-log', 'style' => 'margin: 8px 18px 0 18px;')
            )
        );

        /*$version = new XMLElement('p', 'Symphony ' . Symphony::Configuration()->get('version', 'symphony'), array(
            'id' => 'version'
        ));
        $this->Form->appendChild($version);*/

        $this->Form->appendChild($actions);
    }

}

