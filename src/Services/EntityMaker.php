<?php

namespace App\Services;



//use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class EntityMaker
{
    private $entityName;
    private $fields = [];
    private $fs;
    private $projectPath;

public function __construct($entityName = Null, $fields = [], Filesystem $filesystem , KernelInterface $kernel, $filepath ='/../home/mohamed/telco-churn-project/')
    {
        $this->entityName = ucfirst(strtolower($entityName));
        $this->fields = $fields;
        $this->fs = $filesystem;
        $this->kernel = $kernel;
        $this->projectPath = sys_get_temp_dir().$filepath;
    }


    private function entityAttributeGenerator(){
        $result = '';
        foreach ($this->fields as $field){
            if (strtolower($field['type']) == 'string') {
            $result .= '
            /**
             * @ORM\Column(type="string", length='.$field["length"].', nullable=true)
             */
            private $'.$field["field"].';';

            }elseif (strtolower($field['type']) == 'float'){

                $result .= '
             /**
             * @ORM\Column(type="float", nullable=true)
             */
              private $'.$field['field'].';';
            }elseif (strtolower($field['type']) == 'datetime'){

                $result .= '
             /**
             * @ORM\Column(type="datetime", nullable=true)
             */
              private $'.$field['field'].';';
            }
        }

        return $result;
    }

    private function entityMethodGenerator(){
            $result = '
                public function getId(): ?int
                {
                    return $this->id;
                }
            ';

            foreach ($this->fields as $field){
                if (strtolower($field['type']) == 'string') {
                    $result .='
                        public function get'.ucfirst($field["field"]).'(): ?string
                        {
                            return $this->'.strtolower($field["field"]).';
                        }
                    
                        public function set'.ucfirst($field["field"]).'(?string $'.strtolower($field["field"]).'): self
                        {
                            $this->'.strtolower($field["field"]).' = $'.strtolower($field["field"]).';
                    
                            return $this;
                        }
                    ';
                }elseif (strtolower($field['type']) == 'float'){
                    $result .='
                    
                         public function get'.ucfirst($field["field"]).'(): ?float
                        {
                            return $this->'.strtolower($field["field"]).';
                        }
                    
                        public function set'.ucfirst($field["field"]).'(?float $'.strtolower($field["field"]).'): self
                        {
                            $this->'.strtolower($field["field"]).' = $'.strtolower($field["field"]).';
                    
                            return $this;
                        }
                    ';
                }elseif (strtolower($field['type']) == 'datetime'){
                    $result .='
                    
                         public function get'.ucfirst($field["field"]).'(): ?\DateTimeInterface
                        {
                            return $this->'.strtolower($field["field"]).';
                        }
                    
                        public function set'.ucfirst($field["field"]).'(?\DateTimeInterface $'.strtolower($field["field"]).'): self
                        {
                            $this->'.strtolower($field["field"]).' = $'.strtolower($field["field"]).';
                    
                            return $this;
                        }
                    ';
                }
            }

            return $result;
    }



    public function buildEntity(){

        $generatedEntity = "";
        $generatedEntityRepository = "";
        $generationResult = array(
            "EntityFolderExist" => True,
            "EntityRepositoryFolderExist" => True,
            "EntityFileIsGenerated" => False,
            "EntityRepositoryFileIsGenerated" => False,
        );

        $generatedEntity = '<?php

            namespace App\Entity;
            
            use Doctrine\ORM\Mapping as ORM;
            
            /**
             * @ORM\Entity(repositoryClass="App\Repository\\'.$this->entityName.'Repository")
             */
             class '.$this->entityName.'{
             
                /**
                 * @ORM\Id()
                 * @ORM\GeneratedValue()
                 * @ORM\Column(type="integer")
                 */
                private $id;
          ';
        $generatedEntity .= $this->entityAttributeGenerator();

        $generatedEntity .= $this->entityMethodGenerator();

        $generatedEntity.= "}";

        $generatedEntityRepository .= '<?php

        namespace App\Repository;
        
        use App\Entity\\'.$this->entityName.';
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Symfony\Bridge\Doctrine\RegistryInterface;
        
        /**
         * @method '.$this->entityName.'|null find($id, $lockMode = null, $lockVersion = null)
         * @method '.$this->entityName.'|null findOneBy(array $criteria, array $orderBy = null)
         * @method '.$this->entityName.'[]    findAll()
         * @method '.$this->entityName.'[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
         */
        class '.$this->entityName.'Repository extends ServiceEntityRepository
        {
            public function __construct(RegistryInterface $registry)
            {
                parent::__construct($registry, '.$this->entityName.'::class);
            }
            
          // /**
            //  * @return '.$this->entityName.'[] Returns an array of Person objects
            //  */
            /*
            public function findByExampleField($value)
            {
                return $this->createQueryBuilder("p")
                    ->andWhere("p.exampleField = :val")
                    ->setParameter("val", $value)
                    ->orderBy("p.id", "ASC")
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                ;
            }
            */
        
            /*
            public function findOneBySomeField($value): ?'.$this->entityName.'
            {
                return $this->createQueryBuilder("p")
                    ->andWhere("p.exampleField = :val")
                    ->setParameter("val", $value)
                    ->getQuery()
                    ->getOneOrNullResult()
                ;
            }
            */
         
         }
                
        ';

        //Entity File generation

            try{
                if($this->fs->exists($this->projectPath.'src/Entity')){// Verifie si le repertoire existe
                    if ($this->fs->exists($this->projectPath.'src/Entity/'.$this->entityName.'.php')){
                        $generationResult['EntityFileIsGenerated'] = True;
                        //return [False, "Le fichier Entity $this->entityName existe déja"];
                    }else{
                        $this->fs->appendToFile($this->projectPath.'src/Entity/'.$this->entityName.'.php', $generatedEntity);
                        $generationResult['EntityFileIsGenerated'] = True;
                        //return [True, "Le fichier Entity $this->entityName à été créé avec succès"];
                    }
                }else{// Sinon on retourne une erreur
                    $generationResult['EntityFolderExist'] = False;
                    $generationResult['EntityFileIsGenerated'] = False;
                    //return [False, "Le répertoire Entity $this->entityName  auquel vous tentez d'accéder n'existe pas"];
                }




            }catch (\Exception $e){
                return "Message : ".$e->getMessage();
            }

            //EntityRepository File generation
            try{
                if($this->fs->exists($this->projectPath.'src/Repository')){// Verifie si le repertoire existe
                    if ($this->fs->exists($this->projectPath.'src/Repository/'.$this->entityName.'Repository.php')){
                        $generationResult['EntityRepositoryFileIsGenerated'] = True;
                        //return [False, "Le fichier ".$this->entityName."Repository existe déja"];
                    }else{
                        $this->fs->appendToFile($this->projectPath.'src/Repository/'.$this->entityName.'Repository.php', $generatedEntityRepository);
                        //return [True, "Le fichier ".$this->entityName."Repository à été créé avec succès"];
                        $generationResult['EntityRepositoryFileIsGenerated'] = True;
                    }
                }else{// Sinon on retourne une erreur
                    //return [False, "Le répertoire Repository auquel vous tentez d'accéder n'existe pas"];
                    $generationResult['EntityRepositoryFolderExist'] = False;
                    $generationResult['EntityRepositoryFileIsGenerated'] = False;
                }





            }catch (\Exception $e){
                return "Message : ".$e->getMessage();
            }

            $this->commandLauncher();
            $this->makeCRUDCustom($this->entityName,$this->projectPath,$this->fs,$this->fields);



            return $generationResult;


        }




    public function removeEntity($table = Null){
        if ($table != Null){
            if($this->fs->exists($this->projectPath.'templates/'.strtolower($table)))
                $this->fs->remove($this->projectPath.'templates/'.strtolower($table));
            if($this->fs->exists($this->projectPath.'src/Form/'.ucfirst($table).'Type.php'))
                $this->fs->remove($this->projectPath.'src/Form/'.ucfirst($table).'Type.php');
            if($this->fs->exists($this->projectPath.'src/Controller/'.ucfirst($table).'Controller.php'))
                $this->fs->remove($this->projectPath.'src/Controller/'.ucfirst($table).'Controller.php');
            if($this->fs->exists($this->projectPath.'src/Repository/'.ucfirst($table).'Repository.php'))
                $this->fs->remove($this->projectPath.'src/Repository/'.ucfirst($table).'Repository.php');
            if($this->fs->exists($this->projectPath.'src/Entity/'.ucfirst($table).'.php'))
                $this->fs->remove($this->projectPath.'src/Entity/'.ucfirst($table).'.php');

            $this->commandSanitizerLauncher();
        }else{

        }
    }


        //Execution des commandes de creation de CRUD
    private function commandLauncher(){
        $_1= $this->commandSchemaUpdate();
       // $_2= $this->commandMakeCRUD();
    }

    private function commandSanitizerLauncher(){
        $_1= $this->commandSchemaUpdate();
    }

    private function commandSchemaUpdate(){
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'doctrine:schema:update',
            '-f' => true,
            '--complete' => true,
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);
        return $output->fetch();
    }

    public function makeCRUDCustom($entityname, $projectPath, $filesystem, $fields){
        $controllerMaker = new ControllerMaker($entityname, $projectPath, $filesystem);
        $formMaker = new FormMaker($entityname,$projectPath, $filesystem, $fields);
        $CRUDMaker = new CRUDMaker($entityname,$projectPath,$fields,$filesystem);

        $controllerMaker->buildController();
        $formMaker->buildCustomForm();
        $CRUDMaker->buildTemplates();

    }

    private function commandMakeCRUD(){
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'make:crud',
            //'-n' => True,
            'entity-class' => $this->entityName,

        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);
        return $output->fetch();
    }

    public function commandCacheClear(){
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'cache:clear',

        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);
        return $output->fetch();
    }

    public function commandCacheWarmup(){
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'cache:warmup',
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);
        return $output->fetch();
    }




}
