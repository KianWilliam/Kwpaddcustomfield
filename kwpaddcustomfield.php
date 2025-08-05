<?php 
/*
  * @package plugin kwpaddcustomfield for Joomla! 5.x
 * @version $Id: kwpaddcustomfield 1.0.0 2025-07-25 01:10:10Z $
 * @author KWProductions Co.
 * @copyright (C) 2022- KWProductions Co.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of kwpaddcustomfield.
    kwpaddcustomfield is free software: you can redistribute it and/or adify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    kwpaddcustomfield is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for are details.
    You should have received a copy of the GNU General Public License
    along with kwpaddcustomfield.  If not, see <http://www.gnu.org/licenses/>.
 
*/

?>
<?php

defined('_JEXEC') or die;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\Stream;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Table\Table;



class PlgContentKwpaddcustomfield extends CMSPlugin
{		
	    protected $autoloadLanguage = true;
		protected $app;
		protected $db;
	
		protected $results;
		
		protected $componentName;
		protected $tableName;
		protected $componentForm;
		protected $moduleForm;
		protected $pluginForm;



    public function onAfterInitialise()
	{

		$this->loadLanguage();
		
	
	}
	
	public function onContentPrepareForm($form, $data)
	{
		$this->componentName = $this->params->get('componentname');
		$this->tableName = $this->params->get('tablename');
		$this->componentForm = $this->params->get('componentform');
	    $this->moduleForm = $this->params->get('moduleform');
		$this->pluginForm = $this->params->get('pluginform');

	
        $session = Factory::getSession();


       $session->set("tablename", $this->params->get("tablename"));
		
		
		$app    = Factory::getApplication();
		$option = $app->input->get('option');

		if($app->input->get('id')!==NULL)
				$id = $app->input->get('id');
			//	if(/*isset($app->input->get('id')) && */$app->input->get('extension_id')!==NULL)
       else				
				$id = $app->input->get('extension_id');


		switch($option)
		{
			case 'com_'.$this->componentForm :	
                if(isset($this->componentForm) && $this->componentForm!==NULL)			
				if ($app->isClient('administrator'))
				{					
					Form::addFormPath(__DIR__ . '/Forms');
					$form->loadFile("form", false);				
				}				
				break;
			case 'com_modules':
			    if(isset($this->moduleForm) && $this->moduleForm!==NULL && isset($id) && $id!== NULL && $this->moduleForm==$id)
				if ($app->isClient('administrator'))
				{					
					Form::addFormPath(__DIR__ . '/Forms');
					$form->loadFile("form", false);				
				}			
			break;
			case 'com_plugins':
			    if(isset($this->pluginForm) && $this->pluginForm!==NULL && isset($id) && $id!== NULL && $this->pluginForm==$id)
				if ($app->isClient('administrator'))
				{		
					Form::addFormPath(__DIR__ . '/Forms');
					$form->loadFile("form", false);				
				}
			break;
			
		}

		return true;
	}
	
	
	public function onAjaxKwpaddcustomfield()
	{
		$this->tableName = $this->params->get('tablename');

					
		$app = Factory::getApplication();
		$prefix = $app->getCfg('dbprefix');
        $doc = $app->getDocument();
        $wa = $doc->getWebAssetManager();
      	$wa->registerAndUseScript('kwpmodal', Uri::Root().'plugins/content/kwpaddcustomfield/Field/kwpmodal.modal.js');
					
		
				  $db = Factory::getDbo();
				  $query = $db->getQuery(true);		   	
		          $query->select('*')->from($db->quoteName($this->tableName));
				  $db->setQuery($query);
			      $results = $db->loadObjectList();
						
				
					
			if($results!==NULL):			
						
						
   ?>
		
		<table class=\"table table-striped table-bordered\">
   <thead><tr><th>
    </tr>
   </thead>
   <tbody>
   <?php
       foreach ($results as $result): 
		  if(isset($result->name) && $result->name!==NULL)
		   $nom = $result->name;
	   else
		   $nom = $result->title;
	
	   ?>
	   <tr>
         <td>		 
            <b>		
			<?php
			
               $link_attribs = [
                  'class' => 'select-link',
                  'data-gallery-id' => $result->id,
                  'data-gallery-title' => htmlspecialchars($nom),
               ];
              echo  HTMLHelper::link(
                  '#',
				  $nom,
                  $link_attribs
               );
			   ?>
			   </b>
            <div>
         </td>
      </tr>
	  <?php 
	  endforeach;
	  ?>
	  </tbody></table>
	  <?php
	  endif;
	  
	}
	

		
	



}
