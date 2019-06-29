<?php

namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;

class FormMaker{

    private $entityName;
    private $projectPath;
    private $fields;
    private $fs;

    public function __construct($entityName, $projectPath,Filesystem $filesystem , $fields = [])
    {
        $this->entityName = $entityName;
        $this->projectPath = $projectPath;
        $this->fields = $fields;
        $this->fs = $filesystem;
    }

    private function formFieldsBuilder(){
        $myfunction = 'public function buildForm(FormBuilderInterface $builder, array $options)
        {
        $builder';


        foreach ($this->fields as $field){
            if($field['type'] == 'datetime'){

                $myfunction .= '->add(\''.ucfirst($field["field"]).'\', DateType::class, [\'widget\' => \'single_text\',])';
            }elseif($field['type'] == 'float'){
                $myfunction .= '->add(\''.ucfirst($field["field"]).'\', NumberType::class)';
            }else{
                $myfunction .= '->add(\''.ucfirst($field["field"]).'\')';
            }
        }
        $myfunction .= ';
        }';

        return $myfunction;
    }

    public function buildCustomForm(){

        $capitalizeEntityName = ucfirst($this->entityName);
        $lowercaseEntityName = strtolower($this->entityName);
        $generatedForm = '';

        $generationResult = array(
            "FormFolderExist" => True,
            "FormFileIsGenerated" => False,
        );

        $generatedForm = '<?php 
        namespace App\Form;

        use App\Entity\\'.$capitalizeEntityName.';
        use Symfony\Component\Form\AbstractType;
        use Symfony\Component\Form\FormBuilderInterface;
        use Symfony\Component\OptionsResolver\OptionsResolver;
        use Symfony\Component\Form\Extension\Core\Type\DateType;
        use Symfony\Component\Form\Extension\Core\Type\NumberType;
        
        class '.$capitalizeEntityName.'Type extends AbstractType
        {
        ';

        $generatedForm .= $this->formFieldsBuilder();

                $generatedForm .= ' public function configureOptions(OptionsResolver $resolver)
            {
                $resolver->setDefaults([
                    \'data_class\' => '.$capitalizeEntityName.'::class,
                ]);
            }
        }
        ';

        try{
            if($this->fs->exists($this->projectPath.'src/Form')){// Verifie si le repertoire existe
                if ($this->fs->exists($this->projectPath.'src/Form/'.$this->entityName.'Type.php')){
                    $generationResult['FormFileIsGenerated'] = True;
                    //return [False, "Le fichier Form $this->entityName existe déja"];
                }else{
                    $this->fs->appendToFile($this->projectPath.'src/Form/'.$this->entityName.'Type.php', $generatedForm);
                    $generationResult['FormFileIsGenerated'] = True;
                    //return [True, "Le fichier Entity $this->entityName à été créé avec succès"];
                }
            }else{// Sinon on retourne une erreur
                $generationResult['FormFolderExist'] = False;
                $generationResult['FormFileIsGenerated'] = False;
                //return [False, "Le répertoire Controller $this->entityName  auquel vous tentez d'accéder n'existe pas"];
            }

        }catch (\Exception $e){
            return "Message : ".$e->getMessage();
        }

    }



}