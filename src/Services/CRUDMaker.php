<?php
namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;

class CRUDMaker{

    private $entityName;
    private $projectPath;
    private $fs;
    private $fields;

    public function __construct($entityName, $projectPath, $fields = [], Filesystem $filesystem)
    {
        $this->entityName = $entityName;
        $this->projectPath = $projectPath;
        $this->fs = $filesystem;
        $this->fields = $fields;
    }

    private function tableElements($balise = '', $entityName = '', $isShowed = false){

        $tableHeaderData = '';
        $tableData = '';
        $presentationData = '';


        if ($balise == 'th' and $isShowed == false){
            foreach ($this->fields as $field){
                if(is_array($field['field'])){
                    $select_label = array_pop($field['field']);
                    $tableHeaderData .= '<th>'.ucfirst($select_label).'</th>';
                }
                else
                    $tableHeaderData .= '<th>'.ucfirst($field['field']).'</th>';
            }
            return $tableHeaderData;
        }elseif ($balise == 'td' and $isShowed == false){
            foreach ($this->fields as $field){
                if(is_array($field['field'])){
                    $select_label = array_pop($field['field']);
                    $tableData .= '<td><a href="{{ path(\''.strtolower($this->entityName).'_show\', {\'id\': '.strtolower($this->entityName).'.id}) }}">{{'.$entityName.'.'.strtolower($select_label).'}}</a></td>';

                }else{
                    if ($field['type'] != 'datetime')
                        $tableData .= '<td><a href="{{ path(\''.strtolower($this->entityName).'_show\', {\'id\': '.strtolower($this->entityName).'.id}) }}">{{'.$entityName.'.'.strtolower($field['field']).'}}</a></td>';
                    else
                        $tableData .= '<td><a href="{{ path(\''.strtolower($this->entityName).'_show\', {\'id\': '.strtolower($this->entityName).'.id}) }}">{{'.$entityName.'.'.strtolower($field['field']).'|date(\'d-m-Y\')}}</a></td>';
                }


            }
            return $tableData;
        }elseif($entityName != '' and $isShowed == true){

            foreach ($this->fields as $field){
                $headertemp = "";
                    $temp = '';
                    if(is_array($field['field'])){
                        $headertemp = array_pop($field['field']);
                        $temp = '{{'.$entityName.'.'.strtolower($headertemp).'}}';

                    }elseif($field['type'] != 'datetime'){
                        $headertemp = ucfirst($field['field']);
                        $temp = '{{'.$entityName.'.'.strtolower($field['field']).'}}';

                    }else{
                        $headertemp = ucfirst($field['field']);
                        $temp = '{{'.$entityName.'.'.strtolower($field['field']).'|date(\'d-m-Y\')}}';
                    }

                    $presentationData .= '<tr>
                                            <th>'.$headertemp.'</th>
                                            <td>'.$temp.'</td>
                                        </tr>
                                        ';
            }
            return $presentationData;
        }
    }

    public function buildTemplates(){
        $capitalizeEntityName = ucfirst($this->entityName);
        $lowercaseEntityName = strtolower($this->entityName);

        $generatedFormTemplate = '{{ form_start(form) }}
                                   {{ form_widget(form) }}
                                    <button class=\'btn \' style="background:#3498db;">{{ button_label|default(\'Save\') }}</button>
                                {{ form_end(form) }}';

        $generatedFormDelete = '<form method=\'post\' action=\'{{ path(\''.$lowercaseEntityName.'_delete\', {\'id\': '.$lowercaseEntityName.'.id}) }}\' onsubmit=\'return confirm("Are you sure you want to delete this item?");\'>
                                    <input type=\'hidden\' name=\'_method\' value=\'DELETE\'>
                                    <input type=\'hidden\' name=\'_token\' value=\'{{ csrf_token("delete" ~ '.$lowercaseEntityName.'.id) }}\'>
                                    <button class=\'btn red\' style="margin-top: 50px;position: relative;left: -88px;"><i class="material-icons">delete</i></button>
                                </form>';

        //{% extends 'base.html.twig' %}
        $generatedIndex= '
                            {#{% block title %}'.$capitalizeEntityName.' index{% endblock %}#}
                            
                            {% block body %}
                                <h3 style="margin-bottom: 0px;">'.$capitalizeEntityName.' </h3>
                            
                                <table class="table striped">
                                    <thead>
                                        <tr>
                                        '.$this->tableElements("th").'
                                        <!--<th>Actions</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {% for '.$lowercaseEntityName.' in '.$lowercaseEntityName.'s %}
                                        <tr>
                                        '.$this->tableElements("td", $lowercaseEntityName).'
                                          {#  <td style="display:flex;flex-direction: column;">
                                                <a href="{{ path(\''.$lowercaseEntityName.'_show\', {\'id\': '.$lowercaseEntityName.'.id}) }}"><i style="font-size:x-small;" class="material-icons tooltipped" data-position="left" data-tooltip="Show">remove_red_eye</i></a>
                                               <a href="{{ path(\''.$lowercaseEntityName.'_edit\', {\'id\': '.$lowercaseEntityName.'.id}) }}"><i style="font-size:x-small;"  class="material-icons tooltipped" data-position="left" data-tooltip="Edit">build</i></a>
                                            </td>#}
                                        </tr>
                                    {% else %}
                                        <tr>
                                            <td colspan="5">no records found</td>
                                        </tr>
                                    {% endfor %}
                                    </tbody>
                                </table>
                            
                                <a href="{{ path(\''.$lowercaseEntityName.'_new\') }}" class="btn" style="margin-top:15px;background:#3498db;">Create new <i class="material-icons">add</i></a>
                            {% endblock %}';

        $generatedEdit = '{% extends \'base.html.twig\' %}

                            {% block title %}Edit '.$capitalizeEntityName.'{% endblock %}
                            
                            {% block body %}
                             <div class="white-block" style="padding:15px;">
                                <h1>Edit '.$capitalizeEntityName.'</h1>
                            
                                {{ include(\''.$lowercaseEntityName.'/_form.html.twig\', {\'button_label\': \'Update\'}) }}
                                <div class="button-container">
                                    <div class="child-button-container">
                                        <a href="{{ path(\'dataset_index\') }}" class="btn" style="margin-left: 10px;">back</a>
                                        {{ include(\''.$lowercaseEntityName.'/_delete.html.twig\') }}
                                     </div>
                                </div>
                            </div>
                            {% endblock %}
                        ';

        $generatedNew = '{% extends \'base.html.twig\' %}

                            {% block title %}New '.$capitalizeEntityName.'{% endblock %}
                            
                            {% block body %}
                             <div class="white-block" style="padding:15px;">
                                <h1>Create new '.$capitalizeEntityName.'</h1>
                            
                                {{ include(\''.$lowercaseEntityName.'/_form.html.twig\') }}
                            
                                <a href="{{ path(\'dataset_index\') }}" style="position: relative;left: 75px;bottom: 36px;" class="btn">back</a>
                            </div>
                            {% endblock %}';

        $generatedShow ='{% extends \'base.html.twig\' %}

                            {% block title %}'.$capitalizeEntityName.'{% endblock %}
                            
                            {% block body %}
                            <div class="white-block" style="padding:15px;">
                                <h1>'.$capitalizeEntityName.'</h1>
                            
                                <table class="table">
                                    <tbody>
                                        '.$this->tableElements('',$lowercaseEntityName,true).'
                                    </tbody>
                                </table>
                                <div class="button-container" >
                                
                                    <a href="{{ path(\'dataset_index\') }}" class="btn">back</a>
                                    <a href="{{ path(\''.$lowercaseEntityName.'_edit\', {\'id\': '.$lowercaseEntityName.'.id}) }}" class="btn orange"><i class="material-icons">build</i></a>
                                    {{ include(\''.$lowercaseEntityName.'/_delete.html.twig\') }}
                                </div>
                            </div>
                            {% endblock %}';


        try{
            if($this->fs->exists($this->projectPath.'templates/'.$lowercaseEntityName)){// Verifie si le repertoire existe

            }else{// Sinon on retourne une erreur
                $this->fs->mkdir($this->projectPath.'templates/'.$lowercaseEntityName);
                $generationResult['CRUDFolderExist'] = True;
                $this->fs->appendToFile($this->projectPath.'templates/'.$lowercaseEntityName.'/_delete.html.twig', $generatedFormDelete);
                $this->fs->appendToFile($this->projectPath.'templates/'.$lowercaseEntityName.'/_form.html.twig', $generatedFormTemplate);
                $this->fs->appendToFile($this->projectPath.'templates/'.$lowercaseEntityName.'/edit.html.twig', $generatedEdit);
                $this->fs->appendToFile($this->projectPath.'templates/'.$lowercaseEntityName.'/index.html.twig', $generatedIndex);
                $this->fs->appendToFile($this->projectPath.'templates/'.$lowercaseEntityName.'/new.html.twig', $generatedNew);
                $this->fs->appendToFile($this->projectPath.'templates/'.$lowercaseEntityName.'/show.html.twig', $generatedShow);

                $generationResult['CRUDFilesIsGenerated'] = True;
                //return [False, "Le répertoire Controller $this->entityName  auquel vous tentez d'accéder n'existe pas"];
            }

        }catch (\Exception $e){
            return "Message : ".$e->getMessage();
        }
    }
}