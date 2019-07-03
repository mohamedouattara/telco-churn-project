<?php

namespace App\Services;


use Symfony\Component\Filesystem\Filesystem;

class EnumFieldMaker{

    private $entityName;
    private $projectPath;
    private $fields;
    private $fs;
    private $select_label;
    private $availableOptions;
    private $tmpoptionsarray;

    public function __construct($entityName, $projectPath,Filesystem $filesystem , $fields = [])
    {
        $this->entityName = $entityName;
        $this->projectPath = $projectPath;
        $this->fields = $fields;
        $this->fs = $filesystem;
        $this->select_label = '';
        $this->availableOptions = array();
        $this->tmpoptionsarray = array();
    }



    public function buildClassAttributesAndMethods(){
        $my_attributes = '';



        foreach ($this->fields as $field){ // [[petit, grand, taille], [blanc, noir, couleur]]

            if (is_array($field['field'])){ // oui un tableau
                $this->select_label = array_pop($field['field']);//$this->select_value = taille et $field = [petit, grand]
                $options = $field['field']; // $options = [petit, grand]

                foreach ($options as $option){ //$this->select_value = taille et $options = [petit, grand]
                    $my_attributes .= '
                    const '.strtoupper($this->select_label).'_'.strtoupper($option).'= "'.strtolower($option).'";
                    ';
                    array_push($this->availableOptions, 'self::'.strtoupper($this->select_label).'_'.strtoupper($option));
                }
                $this->tmpoptionsarray = $this->availableOptions; //$this->tmpoptionsarray = [self::TAILLE_PETIT, self::TAILLE_GRNAD]
                $this->availableOptions = array(); //$this->tmpoptionsarray = null
                $my_attributes .= '
                /** @var array user friendly named '.strtolower($this->select_label).' */
                protected static $'.strtolower($this->select_label).'Name = [
                ';

                foreach ($options as $option){
                    $my_attributes .= '
                    self::'.strtoupper($this->select_label).'_'.strtoupper($option).' => "'.ucfirst($option).'",
                    ';
                }
                $my_attributes .='];
                
                ';


                $my_attributes .= '
                    /**
                     * @param  string $'.strtolower($this->select_label).'ShortName
                     * @return string
                     */
                    public static function get'.ucfirst($this->select_label).'Name($'.strtolower($this->select_label).'ShortName)
                    {
                        if (!isset(static::$'.strtolower($this->select_label).'Name[$'.strtolower($this->select_label).'ShortName])) {
                            return "Unknown '.strtolower($this->select_label).' ($'.strtolower($this->select_label).'ShortName)";
                        }
                
                        return static::$'.strtolower($this->select_label).'Name[$'.strtolower($this->select_label).'ShortName];
                    }
                
                    public static function getAvailable'.ucfirst($this->select_label).'s()
                    {
                      
                        return ['.implode(',', $this->tmpoptionsarray).'];
                    }
                    ';

            }

        }

        return $my_attributes;
    }

    public function buildTypeEnum(){

        $capitalizeEntityName = ucfirst($this->entityName);
        $lowercaseEntityName = strtolower($this->entityName);
        $uppercaseEntityName = strtoupper($this->entityName);
        $generatedTypeEnum = '';

        $generationResult = array(
            "FormEnumFolderExist" => True,
            "FormEnumFileIsGenerated" => False,
        );

        $generatedTypeEnum = '<?php

namespace App\Form\Enums;

abstract class '.$capitalizeEntityName.'TypeEnum {';
$generatedTypeEnum .= $this->buildClassAttributesAndMethods();
$generatedTypeEnum .='}';

        try{
            if($this->fs->exists($this->projectPath.'src/Form/Enums')){// Verifie si le repertoire existe
                if ($this->fs->exists($this->projectPath.'src/Form/Enums/'.$this->entityName.'TypeEnum.php')){
                    $generationResult['FormEnumFileIsGenerated'] = True;
                    //return [False, "Le fichier Form $this->entityName existe déja"];
                }else{
                    $this->fs->appendToFile($this->projectPath.'src/Form/Enums/'.$this->entityName.'TypeEnum.php', $generatedTypeEnum);
                    $generationResult['FormEnumFileIsGenerated'] = True;
                    //return [True, "Le fichier Entity $this->entityName à été créé avec succès"];
                }
            }else{// Sinon on retourne une erreur
                $generationResult['FormEnumFolderExist'] = False;
                $generationResult['FormEnumFileIsGenerated'] = False;
                //return [False, "Le répertoire Controller $this->entityName  auquel vous tentez d'accéder n'existe pas"];
            }

        }catch (\Exception $e){
            return "Message : ".$e->getMessage();
        }


    }
}