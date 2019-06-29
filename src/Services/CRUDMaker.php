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
                $tableHeaderData .= '<th>'.ucfirst($field['field']).'</th>';
            }
            return $tableHeaderData;
        }elseif ($balise == 'td' and $isShowed == false){
            foreach ($this->fields as $field){
                if ($field['type'] != 'datetime')
                    $tableData .= '<td>{{'.$entityName.'.'.strtolower($field['field']).'}}</td>';
                else
                    $tableData .= '<td>{{'.$entityName.'.'.strtolower($field['field']).'|date(\'d-m-Y\')}}</td>';

            }
            return $tableData;
        }elseif($entityName != '' and $isShowed == true){

            foreach ($this->fields as $field){
                $temp = '';

                if ($field['type'] != 'datetime')
                    $temp = '{{'.$entityName.'.'.strtolower($field['field']).'}}';
                else
                    $temp = '{{'.$entityName.'.'.strtolower($field['field']).'|date(\'d-m-Y\')}}';

                $presentationData .= '<tr>
                                        <th>'.ucfirst($field['field']).'</th>
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
                                    <button class=\'btn\'>{{ button_label|default(\'Save\') }}</button>
                                {{ form_end(form) }}';

        $generatedFormDelete = '<form method=\'post\' action=\'{{ path(\''.$lowercaseEntityName.'_delete\', {\'id\': '.$lowercaseEntityName.'.id}) }}\' onsubmit=\'return confirm("Are you sure you want to delete this item?");\'>
                                    <input type=\'hidden\' name=\'_method\' value=\'DELETE\'>
                                    <input type=\'hidden\' name=\'_token\' value=\'{{ csrf_token("delete" ~ '.$lowercaseEntityName.'.id) }}\'>
                                    <button class=\'btn\'>Delete</button>
                                </form>';

        $generatedIndex= '{% extends \'base.html.twig\' %}
                            {% block title %}'.$capitalizeEntityName.' index{% endblock %}
                            
                            {% block body %}
                                <h1>'.$capitalizeEntityName.' index</h1>
                            
                                <table class="table">
                                    <thead>
                                        <tr>
                                        '.$this->tableElements("th").'
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {% for '.$lowercaseEntityName.' in '.$lowercaseEntityName.'s %}
                                        <tr>
                                        '.$this->tableElements("td", $lowercaseEntityName).'
                                            <td>
                                                <a href="{{ path(\''.$lowercaseEntityName.'_show\', {\'id\': '.$lowercaseEntityName.'.id}) }}">show</a>
                                                <a href="{{ path(\''.$lowercaseEntityName.'_edit\', {\'id\': '.$lowercaseEntityName.'.id}) }}">edit</a>
                                            </td>
                                        </tr>
                                    {% else %}
                                        <tr>
                                            <td colspan="5">no records found</td>
                                        </tr>
                                    {% endfor %}
                                    </tbody>
                                </table>
                            
                                <a href="{{ path(\''.$lowercaseEntityName.'_new\') }}">Create new</a>
                            {% endblock %}';

        $generatedEdit = '{% extends \'base.html.twig\' %}

                            {% block title %}Edit '.$capitalizeEntityName.'{% endblock %}
                            
                            {% block body %}
                                <h1>Edit '.$capitalizeEntityName.'</h1>
                            
                                {{ include(\''.$lowercaseEntityName.'/_form.html.twig\', {\'button_label\': \'Update\'}) }}
                            
                                <a href="{{ path(\''.$lowercaseEntityName.'_index\') }}">back to list</a>
                            
                                {{ include(\''.$lowercaseEntityName.'/_delete.html.twig\') }}
                            {% endblock %}
                        ';

        $generatedNew = '{% extends \'base.html.twig\' %}

                            {% block title %}New '.$capitalizeEntityName.'{% endblock %}
                            
                            {% block body %}
                                <h1>Create new '.$capitalizeEntityName.'</h1>
                            
                                {{ include(\''.$lowercaseEntityName.'/_form.html.twig\') }}
                            
                                <a href="{{ path(\''.$lowercaseEntityName.'_index\') }}">back to list</a>
                            {% endblock %}';

        $generatedShow ='{% extends \'base.html.twig\' %}

                            {% block title %}'.$capitalizeEntityName.'{% endblock %}
                            
                            {% block body %}
                                <h1>'.$capitalizeEntityName.'</h1>
                            
                                <table class="table">
                                    <tbody>
                                        '.$this->tableElements('',$lowercaseEntityName,true).'
                                    </tbody>
                                </table>
                            
                                <a href="{{ path(\''.$lowercaseEntityName.'_index\') }}">back to list</a>
                            
                                <a href="{{ path(\''.$lowercaseEntityName.'_edit\', {\'id\': '.$lowercaseEntityName.'.id}) }}">edit</a>
                            
                                {{ include(\''.$lowercaseEntityName.'/_delete.html.twig\') }}
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