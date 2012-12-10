<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Admin_backup extends Abstract_backend_controller {

	public function index(){
		$backups = scandir("application/backup/");
		$backups = array_slice($backups, 2);
		sort($backups);
		$this->parser->assign("backups", $backups);
		$this->parser->parse("backend/admin_backup.index.tpl");
	}

	public function make_backup(){
		// DB
		$this->load->dbutil();
		$backup =& $this->dbutil->backup(array(
			"ignore" => array("sessions"),
			"format" => "txt",
			"add_insert" => true,
			"newline" => "\r\n"
		)); 

		// Uploads
		$this->load->library("zip");
		$this->zip->read_dir("public/uploads/", false);
		$this->zip->add_data("database.sql", $backup);
		
		$fileName = "backup" . date("Ymd") . ".zip";
		$this->zip->archive("application/backup/" . $fileName);
		
		$dir = scandir("application/backup/");
		$dir = array_slice($dir, 2); // ., ..
		if(count($dir) > 10){
			sort($dir);
			$file = $dir[0];
			@unlink("application/backup/" . $file);
		}
		
		// Download in one zip
		$this->zip->download($fileName);
	}
	
	public function download($fileName = false){
		if($fileName && (strpos($fileName, "/") || !is_file("application/backup/" . $fileName)) || !$fileName){
			$this->load->helper("url");
			redirect(createUri("admin_backup", "index"));
		}
		$this->load->helper("download");
		force_download($fileName, file_get_contents("application/backup/" . $fileName));
	}
	
	public function restore($fileName = false){
		$backups = scandir("application/backup/");
		$backups = array_slice($backups, 2);
		sort($backups);
		$this->parser->assign("backups", $backups);
		
		if((!$_FILES || !$_FILES["file"] || !$_FILES["file"]["tmp_name"]) && (!$fileName || !is_file("application/backup/" . $fileName))){
			$this->parser->assign("result", false);
			$this->parser->parse("backend/admin_backup.restore.tpl");
		}
		else{
			$f = new finfo(FILEINFO_MIME);
			$this->load->library('unzip');

			$file = $fileName ? "application/backup/" . $fileName : $_FILES["file"]["tmp_name"];
			
			if(
				$f &&
				($mime = $f->file($file)) &&
				preg_match("/^application\/zip/", $mime) &&
				$this->unzip->extract($file, "application/tmp/") &&
				is_file("application/tmp/database.sql") &&
				is_dir("application/tmp/uploads/")
			){
				@rename("application/tmp/uploads", "public/uploads");
				$s = explodeSqlFile("application/tmp/database.sql");
				foreach($s as $query){
					$this->db->query($query);
				}
				
				$this->parser->assign("result", "ok");
			}
			else{
				$this->parser->assign("result", "error");
			}
			
			rrmdir("application/tmp", false);
			
			$this->parser->parse("backend/admin_backup.restore.tpl");
		}
	}
}