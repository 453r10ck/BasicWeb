<?php

class File 
{
	private $file_name;
	private $file_ext;
	private $tmp_name;
	private $size;

	public function __construct($file = [])
	{
		if (!empty($file['name'])) {
			$this->size = $file['size'];
			$this->tmp_name = $file['tmp_name'];
			$this->file_name = $file['name'];
			$this->file_ext = $this->getFileExtension($file);
		} else {
			$this->size = '';
			$this->tmp_name = '';
			$this->file_name = '';
			$this->file_ext = '';
		}	 
	}

	public function getFileName() {
		return $this->file_name;
	}

	private function getFileExtension() {
		$ext = explode('.', $this->file_name);
		array_shift($ext);

		return $ext;
	}

	public function uploadForPost() {
		$path = UPLOAD_POST;

		if ($this->file_name != '') {
			if (file_exists($target)) {
				exit('File already existed');
			}
	
			// check extension
			$white_list = ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'];
			if(array_intersect($this->file_ext, $white_list) !== $this->file_ext) {
				exit('Only image file type is accepted!');
			}

			// check file signature
			$value = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
			$file_signature = exif_imagetype($this->tmp_name);
			if (!in_array($file_signature, $value)) {
				exit('Only image file type is accepted!');
			}
		}

		$target = $path . md5($this->file_name) . '.jpg';
		if (move_uploaded_file($this->tmp_name, $target)) {
			return true;
		} else {
			exit("Sorry, there was an error uploading your file.");
		}
	}
}
