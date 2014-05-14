<?php
namespace ECL\FileBundle\Controller\backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    const REL_FILES_FOLDER = 'bundles/eclfile/files/';
    const FILES_FOLDER = '/web/bundles/eclfile/files/';
    
    private $Filesystem;
    
    public function removeAction()
    {
        $this->Filesystem = new Filesystem;
        foreach ($this->getRequest()->get('file') as $post) {
            $this->removeFile($post['file'][0]);
        }

        return new Response;
    }

    public function uploadAction()
    {
        $this->Filesystem = new Filesystem;
        if (isset($_SERVER['HTTP_X_FILENAME'])) {
            $this->uploadFile();
        }

        return $this->forward('ECLFileBundle:backoffice/Default:getTree');
    }

    public function getTreeAction()
    {
        return $this->render(
            'ECLFileBundle:backoffice:tree.html.twig',
            array('items' => $this->getFileCollection())
        );
    }

    public function indexAction()
    {
        return $this->render('ECLFileBundle:backoffice:index.html.twig');
    }

    private function uploadFile()
    {
        file_put_contents(
            $this->getCurrentFolder().$_SERVER['HTTP_X_FILENAME'],
            file_get_contents('php://input')
        );
    }

    private function removeFile($file_path)
    {
        $this->Filesystem->remove(self::REL_FILES_FOLDER.$file_path);
    }

    private function getCurrentFolder()
    {
        $current_year = date('Y');
        $current_month = date('m');
        $this->Filesystem->mkdir(self::REL_FILES_FOLDER.$current_year, 0755);
        $this->Filesystem->mkdir(self::REL_FILES_FOLDER.$current_year.'/'.$current_month, 0755);

        return self::REL_FILES_FOLDER.$current_year.'/'.$current_month.'/';
    }

    private function getFileCollection()
    {
        $files = array();
        $collection = array();
        $years = Finder\Finder::create()
                 ->directories()
                 ->depth(0)
                 ->in($_SERVER['DOCUMENT_ROOT'].self::FILES_FOLDER);
        foreach ($years as $year) {
            $year_num = $year->getFilename();
            $files[$year_num] = array();
            $months = Finder\Finder::create()
                 ->directories()
                 ->depth(0)
                 ->in($_SERVER['DOCUMENT_ROOT'].self::FILES_FOLDER.$year_num);
            foreach ($months as $month) {
                $month_name = $month->getFilename();
                $files[$year_num][$month_name] = array ();
                $docs = Finder\Finder::create()
                        ->files()
                        ->depth(0)
                        ->in($_SERVER['DOCUMENT_ROOT'].self::FILES_FOLDER.
                          $year_num.'/'.$month_name);
                foreach ($docs as $doc) {
                    $files[$year_num][$month_name][] = $doc->getFilename();
                }
            }
            foreach ($this->getMonthsCollection() as $month) {
                if (isset($files[$year_num][$month])) {
                    $collection[$year_num][$month] = 
                    $files[$year_num][$month];
                }
            }
        }
        
        return $collection;
    }
    
    private function getMonthsCollection()
    {
        return array( '01','02','03','04','05','06','07','08','09','10','11','12');
    }

}
