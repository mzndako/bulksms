<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Class Cart
 * @property Crud_model $crud_model Cart module
 */
class Crud_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}

	function clear_cache()
	{
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	function get_type_name_by_id($type, $type_id = '', $field = 'name')
	{
		return $this->get_full_name($this->get_where($type, array($type . '_id' => $type_id))->row());
	}

	function get_parent_info($parent_id)
	{
		$query = $this->get_where('parent', array('parent_id' => $parent_id));
		return $query->row_array();
	}

	function get_all_students_for_parent($parent_id, $what = "class_id")
	{
		$students = $this->get_where("student", array("parent_id" => $parent_id))->result_array();
		$ids = array();
		foreach ($students as $row) {
			$ids[] = $row[$what];
		}
		return $ids;
	}

	function passed_out()
	{
		return "PASSED_OUT";
	}

	function get_class_group()
	{
		d()->order_by("name_numeric", "ASC");
		return $this->get("class_group")->result_array();
	}

	function get_classes_by_group($allowAllClasses = false)
	{
		d()->order_by("name_numeric", "ASC");
		$classes = $this->get("class")->result_array();
		$group = array();
		foreach ($classes as $class) {
			if (empty($class['class_group_id']))
				continue;
			$group[$class['class_group_id']][$class['class_id']] = $class;
		}
		return $group;
	}


	function get_permitted_subjects($condition = false, $only_subject_teachers = false)
	{
		$ajaxSubject = Array();
		$my_subjects = c()->get('subject')->result_array();
		$classes = get_arrange_id_name("class", "class_id", "teacher_id");

		foreach ($my_subjects as $subj) {
			if (!$condition) {
				if ($only_subject_teachers) {
					if (login_id() != $subj['teacher_id'])
						continue;
				} else {
					if (login_id() != $subj['teacher_id'] && login_id() != getIndex($classes, $subj['class_id']))
						continue;
				}
			}
			$ajaxSubject[$subj['class_id']][$subj['subject_id']] = $subj['name'];
		}
		return $ajaxSubject;
	}

	function get_permitted_class_group($condition = false, $permitted_subjects = null, $include_passed_out = false)
	{
		d()->order_by("name_numeric", "ASC");
		if (!$include_passed_out) {
			d()->where("real_class", 1);
		}
		$classes = $this->get("class")->result_array();

		if (!$include_passed_out) {
			d()->where("real_class_group", 1);
		}
		$cls_group = get_arrange_id_name("class_group", "class_group_id", "name");

		if ($permitted_subjects == null && !$condition) {
			$permitted_subjects = $this->get_permitted_subjects($condition);
		}

		$group = array();
		foreach ($classes as $class) {
			if (empty($class['class_group_id']))
				continue;
			if (!$condition) {
				if (empty(getIndex($permitted_subjects, $class['class_id'])))
					continue;
			}

			$group[$class['class_group_id']]["name"] = getIndex($cls_group, $class['class_group_id']);;
			$group[$class['class_group_id']]["classes"][$class['class_id']] = $class;
		}
		return $group;
	}


	function get_all_classes_with_group()
	{
		d()->order_by("name_numeric", "ASC");
		$classes = $this->get("class")->result_array();
		$cls_group = get_arrange_id_name("class_group", "class_group_id", "name");

		$cls = array();
		foreach ($classes as $class) {
			$class['class_group_name'] = getIndex($cls_group, $class['class_group_id']);
			$cls[$class['class_id']] = $class;
		}
		return $cls;
	}

	function get_ids($table, $where, $what)
	{
		$students = $this->get_where($table, $where)->result_array();
		$ids = array();
		foreach ($students as $row) {
			$ids[] = $row[$what];
		}
		return $ids;
	}

	////////STUDENT/////////////


	function get_students($class_id, $term_id = null)
	{

		$search = $this->get_students_ids($class_id, $term_id);

		if (empty($search))
			return array();

		d()->order_by("surname", "ASC");
		d()->where_in("student_id", $search);
		$query = $this->get('student');
		return $query->result_array();
	}

	function get_students_ids($class_id = 0, $term_id = null)
	{
		if (empty($term_id))
			$term_id = get_setting("current_term");

		$year_id = $this->get_session($term_id);

		if ($class_id != "0" && $class_id != "")
			$this->where("class_id", $class_id);

		$this->where("year_id", $year_id);

		$std = $this->get("student_class")->result_array();
		$search = array();
		foreach ($std as $row)
			$search[] = $row['student_id'];

		return $search;
	}

	function get_user($id, $field = null)
	{
	    return user_data($field, $id, "", false, false);
		if (empty($id))
			return "";

		$x = "users";


		$rs = $this->get_where($table, $config);
		return empty($field) ? $rs->row_array() : getIndex($rs->row_array(), $field);

	}

	function get_updated_by($user_id, $include_staff_id = true)
	{
		$user = $this->get_user($user_id);
		if (empty($user))
			return "";
		$user_type = $this->get_user_type($user);
		if (!empty($user['name'])) {
			return $include_staff_id ? $user['name'] . " ($user_type)" : $user['name'];
		}

		$name = $user['surname'] . " " . $this->abbreviate_name($user['fname']) . " " . $this->abbreviate_name($user["mname"]);
		$id = $this->get_staff_student_id($user);
		return $include_staff_id ? "$name ($id)" : $name;
	}

	function abbreviate_name($name)
	{
		if (empty($name)) {
			return "";
		}
		return strtoupper(substr($name, 0, 1)) . ".";
	}

	function get_student_info($student_id)
	{
		$query = $this->get_where('student', array('student_id' => $student_id));
		return $query->row_array();
	}

	/////////TEACHER/////////////
	function get_teachers()
	{
		$query = $this->get('teacher');
		return $query->result_array();
	}

	function get_academic_teachers()
	{
		d()->where("is_academic", 1);
		$query = $this->get('teacher');
		return $query->result_array();
	}

	function get_teacher_name($teacher_id)
	{
		$query = $this->get_where('teacher', array('teacher_id' => $teacher_id));
		$res = $query->result_array();
		foreach ($res as $row)
			return $this->get_full_name($row);
	}

	function get_teacher_info($teacher_id)
	{
		$query = $this->get_where('teacher', array('teacher_id' => $teacher_id));
		return $query->result_array();
	}

	//////////SUBJECT/////////////
	function get_subjects()
	{
		$query = $this->get('subject');
		return $query->result_array();
	}

	function get_subject_info($subject_id)
	{
		$query = $this->get_where('subject', array('subject_id' => $subject_id));
		return $query->result_array();
	}

	function get_subjects_by_class($class_id)
	{
		$query = $this->get_where('subject', array('class_id' => $class_id));
		return $query->result_array();
	}

	function get_subject_name_by_id($subject_id)
	{
		$query = $this->get_where('subject', array('subject_id' => $subject_id))->row_array();
		return getIndex($query, "name");
	}

	////////////CLASS///////////
	function get_class_name($class_id)
	{
		$query = $this->get_where('class', array('class_id' => $class_id));
		$res = $query->result_array();
		foreach ($res as $row)
			return $row['name'];
	}

	function get_class_name_numeric($class_id)
	{
		$query = $this->get_where('class', array('class_id' => $class_id));
		$res = $query->result_array();
		foreach ($res as $row)
			return $row['name_numeric'];
	}

	function get_classes($group_id = null)
	{
		$this->order_by("name_numeric", "ASC");
		if ($group_id != null) {
			$this->where("class_group_id", $group_id);
		}
		$query = $this->get('class');
		return $query->result_array();
	}

	function get_class_info($class_id)
	{
		$query = $this->get_where('class', array('class_id' => $class_id));
		return $query->result_array();
	}

	//////////EXAMS/////////////
	function get_exams()
	{
		$query = $this->get('exam');
		return $query->result_array();
	}

	function get_exam_info($exam_id)
	{
		$query = $this->get_where('exam', array('exam_id' => $exam_id));
		return $query->result_array();
	}

	function get_term($term_id)
	{
		$this->where('term_id', $term_id);
		return $this->get("term")->row_array();
	}

	//////////GRADES/////////////
	function get_grades()
	{
		$query = $this->get('grade');
		return $query->result_array();
	}

	function get_grade_info($grade_id)
	{
		$query = $this->get_where('grade', array('grade_id' => $grade_id));
		return $query->result_array();
	}

	function get_obtained_marks($exam_id, $class_id, $subject_id, $student_id)
	{
		$marks = $this->get_where('mark', array(
			'subject_id' => $subject_id,
			'exam_id' => $exam_id,
			'class_id' => $class_id,
			'student_id' => $student_id))->result_array();

		foreach ($marks as $row) {
			echo $row['mark_obtained'];
		}
	}

	function get_highest_marks($exam_id, $class_id, $subject_id)
	{
		$this->db->where('exam_id', $exam_id);
		$this->db->where('class_id', $class_id);
		$this->db->where('subject_id', $subject_id);
		$this->db->select_max('mark_obtained');
		$highest_marks = $this->get('mark')->result_array();
		foreach ($highest_marks as $row) {
			echo $row['mark_obtained'];
		}
	}

	function get_name($table, $id)
	{
		$key = $this->tables($table, true)->primary_key;
		return getIndex($this->get_where($table, $key, $id)->row_array(), "name");
	}

	function get_grade($mark_obtained)
	{
		$query = $this->get('grade');
		$grades = $query->result_array();
		foreach ($grades as $row) {
			if ($mark_obtained >= $row['mark_from'] && $mark_obtained <= $row['mark_upto'])
				return $row;
		}
		return array();
	}

	function create_log($data)
	{
		$data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
		$data['ip'] = $_SERVER["REMOTE_ADDR"];
		$location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
		$data['location'] = $location->City . ' , ' . $location->CountryName;
		$this->db->insert('log', $data);
	}

	function get_system_settings()
	{
		$query = $this->get('settings');
		return $query->result_array();
	}

	////////BACKUP RESTORE/////////
	function create_backup($type)
	{
		$this->load->dbutil();


		$options = array(
			'format' => 'txt', // gzip, zip, txt
			'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
			'add_insert' => TRUE, // Whether to add INSERT data to backup file
			'newline' => "\n"               // Newline character used in backup file
		);


		if ($type == 'all') {
			$tables = array('');
			$file_name = 'system_backup';
		} else {
			$tables = array('tables' => array($type));
			$file_name = 'backup_' . $type;
		}

		$backup = &$this->dbutil->backup(array_merge($options, $tables));


		$this->load->helper('download');
		force_download($file_name . '.sql', $backup);
	}

	/////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
	function restore_backup()
	{
		move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
		$this->load->dbutil();


		$prefs = array(
			'filepath' => 'uploads/backup.sql',
			'delete_after_upload' => TRUE,
			'delimiter' => ';'
		);
		$restore = &$this->dbutil->restore($prefs);
		unlink($prefs['filepath']);
	}

	/////////DELETE DATA FROM TABLES///////////////
	function truncate($type)
	{
		if ($type == 'all') {
			$this->db->truncate('student');
			$this->db->truncate('mark');
			$this->db->truncate('teacher');
			$this->db->truncate('subject');
			$this->db->truncate('class');
			$this->db->truncate('exam');
			$this->db->truncate('grade');
		} else {
			$this->db->truncate($type);
		}
	}

	function get_image_path($type)
	{
		$x = $type;
		return "uploads/" . $x;
	}

	function get_file_name($type, $id, $id_prefix = null)
	{
		if ($id_prefix == null || $id_prefix == "") {
			$id = $type . "_" . $id;
		} else
			$id = $id_prefix . "_" . $id;
		return $id . ".jpg";
	}

	////////IMAGE URL//////////
	function get_image_url($type = '', $id = '', $default = '')
	{

		$path = $this->get_image_path($type);

		d()->where("document_type", $type);
		d()->where("document_type_id", $id);
		$result = c()->get("document");
		if ($result->num_rows() == 0) {
			return $default;
		}
		$row = $result->row_array();

		$image = $path . "/" . $row['document_id'] . "." . $row['ext'];
		if (file_exists($image))
			$image_url = base_url() . $image;
		else {
			$image_url = $default;
		}

		return $image_url;
	}


	function defaultDocument($type, $full_path = true)
	{
		$x = array("profile" => "uploads/default/user.png",
			'logo' => 'uploads/default/logo.png',
			'pins' => "uploads/default/pins.xlsx",
			'student_import' => "uploads/default/student_import.xlsx",
			'cbt_question' => "uploads/default/cbt_question.xlsx",
			'document' => "uploads/default/document.png"
		);

		$y = isset($x[$type]) ? $x[$type] : $x['profile'];

		return $full_path ? base_url() . $y : $y;
	}

	function getDocumentPath($document_id = null, $type = null, $type_id = null)
	{
		if (empty($document_id)) {
			d()->where("document_type", $type);
			d()->where("document_type_id", $type_id);
		} else {
			d()->where("document_id", $document_id);
		}
		$result = c()->get("document");
		if ($result->num_rows() == 0) {
			return '';
		}
		$row = $result->row_array();
		$path = $this->get_image_path($row['document_type']);
		return "$path/$document_id.$row[ext]";
	}

	function getFullDocumentPath($document_id)
	{
		$x = $this->getDocumentPath($document_id);
		if (empty($x))
			return "";
		return base_url() . $x;
	}

	function create_document($document_id, $content)
	{
		$file = $this->getDocumentPath($document_id);
		if (!empty($file)) {
			if (!file_exists(dirname($file))) {
				mkdir(dirname($file));
			}
			file_put_contents($file, $content);
		}
	}

	function delete_document($type = '', $type_id = '', $document_id = '')
	{
		if (empty($document_id)) {
			d()->where("document_type", $type);
			d()->where("document_type_id", $type_id);
		} else {
			d()->where("document_id", $document_id);
		}
		$array = c()->get("document")->result_array();
		foreach ($array as $row) {
			$file = $this->getDocumentPath($row['document_id']);
			@unlink($file);
			d()->where("document_id", $row['document_id']);
			d()->update("document", array("deleted" => 1));
		}
	}


	function move_image($source, $type, $type_id, $allow_multiple = false, $previous_id = '', $title = "", $max_size = 1024 * 10, $acceptExt="")
	{

		$max_size *= 1024;
		if (empty($_FILES[$source]['tmp_name'])) {
			return "No file Selected";
		}

		$path = $this->get_image_path($type);
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}

		$path_parts = pathinfo($_FILES[$source]["name"]);
		$extension = $path_parts['extension'];

		if($_FILES[$source]["size"] > $max_size){
			return "Upload File can not exceed ".$this->convert_to_mb($max_size).". Current Size = ".$this->convert_to_mb($_FILES[$source]["size"]);
		}

		if(!empty($acceptExt) && stripos($acceptExt, $extension) === false){
			return "Only the Following File Extension are accepted $acceptExt";
		}


		if (!empty($previous_id)) {
			$this->where("document_id", $previous_id);
			$row = $this->get("document")->row_array();
			if (!empty($row)) {
				return "Invalid Document ID Submitted";
			}
			@unlink("$path/$row[document_id].$row[ext]");
			$file = "$path/$row[document_id].$extension";
		} else if ($allow_multiple) {
			$data['document_type'] = $type;
			$data['document_type_id'] = $type_id;
			$data['title'] = $title;
			$data['ext'] = $extension;
			$this->insert("document", $data);
			$insert_id = $this->insert_id();
			$file = "$path/$insert_id.$extension";
		} else {

			$this->where("document_type_id", $type_id);
			$this->where("document_type", $type);
			$row = $this->get("document");
			if ($row->num_rows() == 0) {
				$data['document_type'] = $type;
				$data['document_type_id'] = $type_id;
				$data['title'] = $title;
				$data['ext'] = $extension;
				$this->insert("document", $data);
				$insert_id = $this->insert_id();
				$file = "$path/$insert_id.$extension";
			} else {
				$row = $row->row_array();
				$insert_id = $row['document_id'];
				@unlink("$path/$row[document_id].$row[ext]");
				$file = "$path/$row[document_id].$extension";
			}

		}

		$result = move_uploaded_file($_FILES[$source]['tmp_name'], $file);
		if ($result) {
			if (!empty($previous_id)) {
				$this->where("document_id", $previous_id);
				$xxx['ext'] = $extension;
				$this->update("document", $xxx);
				return true;
			} else if (!$allow_multiple) {
				$this->where("document_id", $insert_id);
				$xxx['ext'] = $extension;
				$this->update("document", $xxx);
				return true;
			}
		} else {
			return 'Error uploading file';
		}

		return true;


	}


	function convert_to_mb($data){
		$x = (int) $data;
		if($x < 1024)
			return $x." byte";
		if($x < 1024 * 1024)
			return round($x / 1024, 2)." KB";
		return round($x / (1024 * 1024), 2)." MB";
	}


	function construct_image($options)
	{
		$type = isset($options['type']) ? $options['type'] : "student";
		$id = isset($options['id']) ? $options['id'] : -1;
		$id_prefix = isset($options['id_prefix']) ? $options['id_prefix'] : null;
		$onlyshow = isset($options['onlyshow']) ? $options['onlyshow'] : false;
		$name = isset($options['name']) ? $options['name'] : "image";
		$image_link = $this->get_image_url($type, $id);

		if (empty($image_link)) {
			$image_link = empty($options['default']) ? $this->defaultDocument($type) : $options['default'];
		}
		if ($onlyshow) {
			return '
            <div>
            <a href="' . $image_link . '" title="Click to View" target="_blank"><img style="width: 100px; height: 100px;"
            src="' . $image_link . '"
            alt="' . $type . '"></a>
            </div>
            ';
		}
		return '
<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
				<img src="' . $image_link . '" alt="...">
</div>
				<div align="center">
					<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="' . $name . '" accept="image/*"></span>
					<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
				</div>
			</div>
        ';
	}

	////////STUDY MATERIAL//////////
	function save_study_material_info()
	{
		$data['timestamp'] = strtotime($this->input->post('timestamp'));
		$data['title'] = $this->input->post('title');
		$data['description'] = $this->input->post('description');
		$data['file_name'] = $_FILES["file_name"]["name"];
		$data['file_type'] = $this->input->post('file_type');
		$data['class_id'] = $this->input->post('class_id');

		$this->insert('document', $data);

		$document_id = $this->insert_id();
		move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" . $_FILES["file_name"]["name"]);
	}

	function select_study_material_info()
	{
		$this->db->order_by("timestamp", "desc");
		return $this->get('document')->result_array();
	}

	function select_study_material_info_for_student()
	{
		$student_id = $this->session->userdata('student_id');
		$class_id = $this->get_where('student', array('student_id' => $student_id))->row()->class_id;
		$this->db->order_by("timestamp", "desc");
		return $this->get_where('document', array('class_id' => $class_id))->result_array();
	}

	function update_study_material_info($document_id)
	{
		$data['timestamp'] = strtotime($this->input->post('timestamp'));
		$data['title'] = $this->input->post('title');
		$data['description'] = $this->input->post('description');
		$data['class_id'] = $this->input->post('class_id');

		$this->db->where('document_id', $document_id);
		$this->db->update('document', $data);
	}

	function delete_study_material_info($document_id)
	{
		$this->db->where('document_id', $document_id);
		$this->delete('document');
	}


	function convert2text($message)
	{
		$message = str_ireplace(array("<br>"), "\n", $message);
		return trim(strip_tags($message));
	}

	////////private message//////
	function send_new_private_message()
	{

		$message = $this->input->post('message');
		$textmessage = $this->convert2text($message);
		$timestamp = strtotime(date("Y-m-d H:i:s"));

		$recievers = $this->input->post('reciever');
		if (!is_array($recievers)) $recievers = array();

		$more = $this->input->post('more');


		$email_subject = $this->input->post('email_subject');
		$sms_subject = $this->input->post('sms_subject');

		$send_email = $this->input->post('send_email') == 1 ? true : false;
		$send_sms = $this->input->post('send_sms') == 1 ? true : false;

		foreach ($recievers as $reciever) {

			$sender = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');

			//check if the thread between those 2 users exists, if not create new thread
			$num1 = $this->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
			$num2 = $this->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

			if ($num1 == 0 && $num2 == 0) {
				$message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
				$data_message_thread['message_thread_code'] = $message_thread_code;
				$data_message_thread['sender'] = $sender;
				$data_message_thread['reciever'] = $reciever;
				$this->insert('message_thread', $data_message_thread);
			}
			if ($num1 > 0)
				$message_thread_code = $this->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
			if ($num2 > 0)
				$message_thread_code = $this->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


			$data_message['message_thread_code'] = $message_thread_code;
			$data_message['message'] = $message;
			$data_message['sender'] = $sender;
			$data_message['timestamp'] = $timestamp;
			$this->insert('message', $data_message);

			if ($send_email) {
				$email = user_data("email", $reciever);
				if ($this->is_email($email))
					$this->send_mail($this->replace_values($message, $reciever), $email_subject, $email, $reciever);
			}

			if ($send_sms) {
				$phone = user_data("phone", $reciever);
				if (is_numeric($phone))
					$this->send_sms($this->replace_values($textmessage, $reciever), $sms_subject, $phone, $reciever);
			}
		}


		if ($more != null) {
			$add = explode(",", $more);
			foreach ($add as $number) {
				$is_email = $this->is_email($number);
				if ($is_email && $send_email) {
					$email = $number;
					$this->send_mail($message, $email_subject, $email);
				} elseif ($send_sms) {
					$phone = $number;
					if (is_numeric($phone))
						$this->send_sms($textmessage, $sms_subject, $phone);
				}
			}
		}

		return $message_thread_code;
	}

	function send_new_private_lesson($current_term)
	{
		$message = $this->input->post('message');
		$timestamp = strtotime(date("Y-m-d H:i:s"));

		$reciever = "admin";
		$title = $this->input->post('title');
		$sender = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');

		//check if the thread between those 2 users exists, if not create new thread
		$num1 = $this->get_where('lesson_thread', array('sender' => $sender, 'reciever' => $reciever, "term_id" => $current_term))->num_rows();
		$num2 = $this->get_where('lesson_thread', array('sender' => $reciever, 'reciever' => $sender, "term_id" => $current_term))->num_rows();

		if ($num1 == 0 && $num2 == 0) {
			$message_thread_code = substr(md5(time() . rand(100000000, 20000000000)), 0, 15);
			$data_message_thread['message_thread_code'] = $message_thread_code;
			$data_message_thread['sender'] = $sender;
			$data_message_thread['reciever'] = $reciever;
			$data_message_thread['term_id'] = $current_term;
			$this->insert('lesson_thread', $data_message_thread, 'message_thread_id');
		}

		if ($num1 > 0)
			$message_thread_code = $this->get_where('lesson_thread', array('sender' => $sender, 'reciever' => $reciever, "term_id" => $current_term))->row()->message_thread_code;
		if ($num2 > 0)
			$message_thread_code = $this->get_where('lesson_thread', array('sender' => $reciever, 'reciever' => $sender, "term_id" => $current_term))->row()->message_thread_code;


		$data_message['message_thread_code'] = $message_thread_code;
		$data_message['message'] = $message;
		$data_message['sender'] = $sender;
		$data_message['title'] = $title;
		$data_message['timestamp'] = $timestamp;
		$data_message['term_id'] = $current_term;
		$this->insert('lesson', $data_message, 'message_id');

		// notify email to email reciever
		//$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

		return $message_thread_code;
	}

	function send_reply_message($message_thread_code)
	{
		$message = $this->input->post('message');
		$timestamp = strtotime(date("Y-m-d H:i:s"));
		$sender = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');


		$data_message['message_thread_code'] = $message_thread_code;
		$data_message['message'] = $message;
		$data_message['sender'] = $sender;
		$data_message['timestamp'] = $timestamp;
		$this->insert('message', $data_message, "message_id");

		// notify email to email reciever
//        $this->email_model->notify_email('new_message_notification', $this->db->insert_id());
	}

	function send_reply_lesson($message_thread_code)
	{
		$message = $this->input->post('message');
		$timestamp = strtotime(date("Y-m-d H:i:s"));
		$sender = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');


		$data_message['message_thread_code'] = $message_thread_code;
		$data_message['message'] = $message;
		$data_message['sender'] = $sender;
		$data_message['timestamp'] = $timestamp;
		$this->insert('lesson', $data_message, "message_id");

		// notify email to email reciever
//        $this->email_model->notify_email('new_message_notification', $this->db->insert_id());
	}

	function mark_thread_messages_read($message_thread_code)
	{
		// mark read only the oponnent messages of this thread, not currently logged in user's sent messages
		$current_user = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');
		$this->db->where('sender !=', $current_user);
		$this->db->where('message_thread_code', $message_thread_code);
		$this->db->update('message', array('read_status' => 1));
	}

	function count_unread_message_of_thread($message_thread_code)
	{
		$unread_message_counter = 0;
		$current_user = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');
		$messages = $this->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
		foreach ($messages as $row) {
			if ($row['sender'] != $current_user && $row['read_status'] == '0')
				$unread_message_counter++;
		}
		return $unread_message_counter;
	}

	function mark_thread_lesson_read($current_term, $message_thread_code, $isadmin)
	{
		// mark read only the oponnent messages of this thread, not currently logged in user's sent messages
		if ($isadmin)
			$type = "read_status";
		else
			$type = "user_read_status";

		$current_user = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');
//        $this->db->where('sender !=', $current_user);
		$this->db->where('message_thread_code', $message_thread_code);
		$this->db->where('term_id', $current_term);
		$this->db->update('lesson', array($type => 1));
	}

	function count_unread_lesson_of_thread($message_thread_code, $isadmin)
	{
		$unread_message_counter = 0;

		$current_user = $this->session->userdata('login_as') . '-' . $this->session->userdata('login_user_id');

		$messages = $this->get_where('lesson', array('message_thread_code' => $message_thread_code))->result_array();
		foreach ($messages as $row) {
			if ($isadmin) {
				if ($row['sender'] != $current_user && $row['read_status'] == '0')
					$unread_message_counter++;
			} else {
				if ($row['user_read_status'] == '0')
					$unread_message_counter++;
			}
		}
		return $unread_message_counter;
	}

	function get_setting($key, $default = "")
	{

		d()->where("owner", owner);
		$q = $this->db->get_where('settings', array('type' => $key));
		if ($q->num_rows() > 0) {
			return $q->row()->description;
		} else
			return $default;

	}

	function save_setting($key, $value = "", $owner = null)
	{
		return $this->set_setting($key, $value, $owner);
	}

	function set_setting($key, $value, $owner = null)
	{
		return save_setting($key, $value, $owner);
	}

	function safer_where_in($key, $array)
	{
		if (empty($array)) {
			d()->where("1=2");
		} else {
			d()->where_in($key, $array);
		}
	}

	function where($key, $value = null)
	{
		return $this->db->where($key, $value);
	}

	function limit($limit, $offset = 0)
	{
		return $this->db->limit($limit, $offset);
	}

	function order_by($orderby, $direction = "", $escape = null)
	{
		return $this->db->order_by($orderby, $direction, $escape);
	}

	function get($table = null)
	{
		return $this->get_where($table, array());
	}

	function get_row($table, $key, $value = '', $column = null)
	{
		$rs = $this->get_where($table, $key, $value)->row_array();
		return empty($column) ? $rs : getIndex($rs, $column);
	}

	function last_row_value($table, $column)
	{
		d()->order_by($column, "DESC");
		d()->limit(1);
		return getIndex($this->get($table)->row_array(), $column);
	}

	function get_where($table = null, $config, $value = null)
	{
		if (!is_array($config)) {
			$key = $config;
			$config = array();
			$config[$key] = $value;
		}

		if (isset($config['owner'])) {
			if ($config['owner'] = "" || $config['owner'] === false) {
				unset($config['owner']);
			}
		} else {
			$config['owner'] = owner;
		}

		if (empty($table)) {
			return false;
		}

		return d()->get_where($table, $config);

	}

	function count_all($table)
	{
		$this->where("owner", owner);
		return d()->count_all_results($table);

	}


	function join($from_table, $with_table, $where)
	{
		d()->from($from_table);
		return d()->join($with_table, $where);
	}

	public $guid = null;

	function insert($table, $config)
	{
		$config['owner'] = owner;
		return $this->db->insert($table, $config);
	}

	function insert_id()
	{
		return d()->insert_id();
	}

	function insert_batch($table, $data)
	{
		foreach ($data as $key => $value) {
			$data[$key]['owner'] = owner;
		}

		return $this->db->insert_batch($table, $data);
	}

	function update($table, $data = array(), $where = array())
	{
		if (!empty($where))
			d()->where($where);
//        $config['owner'] = owner;
		d()->where("owner", owner);
		return $this->db->update($table, $data);
	}

	function delete($table, $key = null, $value = null)
	{
		if (!empty($key)) {
			if (is_array($key))
				$this->where($key);
			else
				$this->where($key, $value);
		}

		$this->where("owner", owner);
		return $this->db->delete($table);
	}


	function previous_term($term_id)
	{
		$session_id = $this->get_where("term", array("term_id" => $term_id))->row()->year_id;
		$this->order_by("start", "ASC");
		$terms = $this->get_where("term", array("year_id" => $session_id))->result_array();


		$count = 0;
		foreach ($terms as $term) {
			if ($term['term_id'] == $term_id) {
				break;
			}
			$count++;
		}
		$count--;
		return isset($terms[$count]) ? $terms[$count]['term_id'] : 0;
	}

	function academic_history($student_id)
	{
		return "Coming Soon";
		$ajaxSession = Array();
		d()->order_by("name_numeric", "ASC");
		$myyears = $this->get('year')->result_array();
		foreach ($myyears as $year) {
			d()->order_by("start", "ASC");
			$terms = $this->get_where('term', array('year_id' => $year['year_id']))->result_array();
			foreach ($terms as $term) {
				$ajaxSession[$term['term_id']] = array("session" => $year['name'], "name" => $term['name']);;
			}
		}

		$history = $this->get_where("student_class", "student_id", $student_id)->result_array();
		$myhistory = array();
		foreach ($history as $row) {
			$myhistory[$row['year_id']][] = $row;
		}

		$classes = $this->get_all_classes_with_group();
		$array = array();
		foreach ($ajaxSession as $term_id => $term_array) {
			$x = getIndex($myhistory, $term_id, array());
			foreach ($x as $row) {
				$row['term_name'] = $term_array['name'];
				$row['session_name'] = $term_array['session'];
				$row['class_name'] = getIndex($classes, $row['class_id'] . ",name");
				$row['class_group_name'] = getIndex($classes, $row['class_id'] . ",class_group_name");
				$array[] = $row;
			}
		}

		return $array;
	}

	function get_next_term($term_id, $returncount = 1, $next = true)
	{
		if ($next) $this->order_by("start", "ASC");
		else $this->order_by("start", "DESC");

		$terms = $this->get("term")->result_array();

		$count = null;
		for ($i = 0; $i < count($terms); $i++) {
			if ($terms[$i]['term_id'] == $term_id) {
				$count = $i;
				break;
			}
		}
		if ($count === null)
			return "";

		$idx = $returncount + $count;
		return isset($terms[$idx]) ? $terms[$idx]['term_id'] : "";
	}

	function get_student_class_id($term_id, $student_id = null)
	{
		$year_id = $this->get_session($term_id);

		$this->where("year_id", $year_id);

		if ($student_id === null) {
			return get_arrange_id_name("student_class", "student_id", "class_id");
		}

		$this->where("student_id", $student_id);
		$array = $this->get("student_class")->row_array();
		return getIndex($array, 'class_id');
	}

	function update_student_class_id($student_id, $class_id, $term_id = null, $extra = array())
	{
		if (empty($term_id))
			$term_id = get_setting("current_term");

		$year_id = $this->get_session($term_id);

		d()->where("student_id", $student_id);
		d()->where("year_id", $year_id);

		$result = $this->get("student_class");

		$extra['class_id'] = $class_id;
		if ($result->num_rows() > 0) {
			$this->where("student_class_id", $result->row()->student_class_id);
			$this->update('student_class', $extra);
		} else {
			$extra['student_id'] = $student_id;
			$extra['year_id'] = $year_id;
			$extra['date'] = time();
			$this->insert("student_class", $extra);
		}

		d()->where("student_id", $student_id);
		c()->update("student", array("class_id" => $class_id));

	}

	function get_students_result($term_id, $class_id = null, $student_id = null)
	{

		if (empty($student_id) && empty($class_id))
			return array();

		if (empty($class_id)) {
			$class_id = $this->get_student_class_id($term_id, $student_id);
		}

		//GET ALL TERMS FOR THE CURRENT SESSION
		$session_id = $this->get_session($term_id);
		$this->order_by("start", "ASC");
		$terms = $this->get_where("term", array("year_id" => $session_id))->result_array();
		$term_ids = get_ids($terms, 'term_id');


		//GET ALL EXAMS FOR THE SESSION
		$this->order_by("name_numeric", "ASC");
		$this->safer_where_in("term_id", $term_ids);
		$this->where(array("class_id" => $class_id));
		$exams = $this->get("exam")->result_array();
		$exam_ids = get_ids($exams, 'exam_id');

		//GET ALL STUDENTS FOR THE CLASS AND TERM SPECIFIED
		$students = $this->get_students($class_id, $term_id);
		$student_ids = get_ids($students, "student_id");

		//GET SUBJECTS FOR THE CLASS
		$subjects = $this->get_where("subject", array("class_id" => $class_id))->result_array();


		//GET ALL MARKS FOR THE ABOVE STUDENTS and TERM EXAM
		$this->safer_where_in("student_id", $student_ids);
		$this->safer_where_in("exam_id", $exam_ids);
		$marks = $this->get('mark')->result_array();

		$my_exams = array();
		foreach ($exams as $exam) {
			$my_exams[$exam['exam_id']] = $exam['term_id'];
		}

		$my_mark = array();
		foreach ($marks as $mark) {
			$score = $mark['mark_obtained'];
			if (isset($my_exams[$mark['exam_id']])) {
				$my_mark[$mark['student_id']][$my_exams[$mark['exam_id']]][$mark['subject_id']][$mark['exam_id']] = $score;
			}
		}

		$real_exams = array();
		foreach ($exams as $exam) {
			$real_exams[$exam['term_id']][] = $exam;
		}

		$pos = array();
		$myp = array();
		foreach ($students as $student) {
			$total = 0;

			foreach ($terms as $term) {
				$term_total = 0;
				$my_mark[$student['student_id']][$term['term_id']]['per_total'] = 0;

				//LOOPING THROUGH SUBJECTS
				foreach ($subjects as $subject) {
					$subtotal = 0;
					$real_myexam = isset($real_exams[$term['term_id']]) ? $real_exams[$term['term_id']] : array();
					$total_mark = 0;

					//LOOPING THROUGH EXAMS
					foreach ($real_myexam as $exam) {
						if (!isset($my_mark[$student['student_id']][$term['term_id']][$subject['subject_id']][$exam['exam_id']])) {
							$my_mark[$student['student_id']][$term['term_id']][$subject['subject_id']][$exam['exam_id']] = 0;
						}
						$score = $my_mark[$student['student_id']][$term['term_id']][$subject['subject_id']][$exam['exam_id']];

						$subtotal += $score;
						$total += $score;
						$term_total += $score;
						$total_mark += $exam['mark'];

						//SET EXPECTED TOTAL MARK PER TERM
						@$my_mark[$student['student_id']][$term['term_id']]['per_total'] += $exam['mark'];

						//SET TOTAL MARK OBTAINED PER TERM PER SUBJECT
						@$my_mark["GET"][$term['term_id']][$subject['subject_id']]['per_total'] += $exam['mark'];//TOTAL MARK
						@$my_mark["GET"][$term['term_id']][$subject['subject_id']]['total'] += $score;//MARK OBTAINED

					}


					//SET MARK OBTAINED PER SUBJECT FOR THE STUDENT
					$my_mark[$student['student_id']][$term['term_id']][$subject['subject_id']]['total'] = $subtotal;

					//SET MARK OBTAINED PER SUBJECT FOR POSITION
					$myp['term_' . $term['term_id'] . '-subject_' . $subject['subject_id']][$student['student_id']] = $subtotal;
//                    $myp['term_'.$term['term_id'].'-subject_'.$subject['subject_id']][$student['student_id']] = $subtotal;
				}

				//SET COMMULATIVE AND TOTAL TERM MARK FOR POSITION
				$myp['term_' . $term['term_id']][$student['student_id']] = $term_total;
				$myp['com_term_' . $term['term_id']][$student['student_id']] = $total;

				//SET TOTAL MARK OBTAINED FOR THE TERM PER STUDENT
				$my_mark[$student['student_id']][$term['term_id']]['total'] = $term_total;

				//SET CUMULATIVE TOTAL MARK OBTAIN PER STUDENT
				$my_mark[$student['student_id']][$term['term_id']]['com_total'] = $total;

				//GET TOTAL EXPECTED MARK FOR A STUDENT
				$grade_total = $my_mark[$student['student_id']][$term['term_id']]['per_total'];

				//SET PERCENTAGE TOTAL MARK PER STUDENT
				$my_mark[$student['student_id']][$term['term_id']]['per_total'] = $this->percentage($term_total,
					$grade_total);
			}

			$my_mark[$student['student_id']]['total'] = $total;

		}

		$my_mark['GET']['TOTAL_STUDENTS'] = count($students);


		foreach ($terms as $term) {
			$this->getPosition($my_mark, $myp, 'term_' . $term['term_id']);
			$this->getPosition($my_mark, $myp, 'com_term_' . $term['term_id']);
			foreach ($subjects as $subj) {
				$this->getPosition($my_mark, $myp, 'term_' . $term['term_id'] . '-subject_' . $subj['subject_id']);
			}
		}
//print_r($myp);
//        foreach($subjects as $subj) {
//            $this->getPosition($my_mark,$myp,'subject_'.$subj['subject_id']);
//            $this->getPosition($my_mark,$myp,'com_term_'.$term['term_id']);
//        }

		return $my_mark;
		arsort($pos);

		$newp = 0;
		$prevp = 0;
		$pt = 0;
		foreach ($pos as $id => $p) {
			$newp++;
			if ($pt == $p) {
				$my_mark[$id]['position'] = $prevp;
			} else {
				$my_mark[$id]['position'] = $newp;
				$prevp = $newp;
			}

			$pt = $p;
		}

	}

	function getPosition(&$my_mark, $myp, $suffix)
	{
		$pos = getIndex($myp, $suffix, array());
		arsort($pos);
		$newp = 0;
		$prevp = 0;
		$pt = 0;
		foreach ($pos as $id => $p) {
			$newp++;
			if ($pt == $p) {
				$my_mark[$id][$suffix] = $prevp;
			} else {
				$my_mark[$id][$suffix] = $newp;
				$prevp = $newp;
			}

			$pt = $p;
		}
	}

	function percentage($top, $botton, $round = 2)
	{
		if (empty($botton) || empty($top))
			return 0;

		return round(($top / $botton * 100), $round);
	}

	function average($total, $count, $round = 2)
	{
		if (empty($total) || empty($count))
			return 0;
//print "$total / $count";
		return round($total / $count, $round, PHP_ROUND_HALF_UP);
	}

	function ajaxSession($allowAllSession = false)
	{
		$ajaxSession = Array();
		d()->order_by("name_numeric", "ASC");
		$myyears = $this->get('year')->result_array();
		foreach ($myyears as $year) {
			d()->order_by("start", "ASC");
			$terms = $this->get_where('term', array('year_id' => $year['year_id']))->result_array();
			if ($allowAllSession)
				$ajaxSession[$year['year_id']][] = array("id" => 0, "name" => "All Terms");;
			foreach ($terms as $term) {
				$ajaxSession[$year['year_id']][] = array("id" => $term['term_id'], "name" => $term['name']);;
			}
		}
		return $ajaxSession;
	}

	function all_terms()
	{
		$ajaxSession = Array();
		d()->order_by("name_numeric", "ASC");
		$myyears = $this->get('year')->result_array();
		foreach ($myyears as $year) {
			$terms = $this->get_where('term', array('year_id' => $year['year_id']))->result_array();
//            $terms = $this->rearrange($terms,$year['myorder'],"term_id");
			foreach ($terms as $term) {
				$ajaxSession[$term['term_id']] = array("session_id" => $term['year_id'], "term_name" => $term['name'], 'session_name' => $year['name']);;
			}
		}
		return $ajaxSession;

	}

	function print_list_terms($current_term = "", $allowAllSession = false)
	{
		echo '
        var currentterm = "', $current_term, '";
        var currentterm2 = currentterm;
        var session = ', json_encode($this->ajaxSession($allowAllSession)), ';
        function list_terms(ses,term){
            if(ses === undefined)
                var term_id = $("#session").val();
            else
                var term_id = $("#"+ses).val();
            if(term === undefined)
                 $el = $("#term");
            else
                 $el = $("#"+term);
            try {
                $el.html("");
                if(term_id == "0"){
                    $el.append($("<option></option>")
                                .attr("value", 0).text("All Terms"));
                }else{
                    var lop = session[term_id];
                    $.each(lop, function (key, value) {
                        if(currentterm == value.id){
                            $el.append($("<option selected></option>")
                                .attr("value", value.id).text(value.name));
                        }else{
                            $el.append($("<option></option>")
                                .attr("value", value.id).text(value.name));
                        }
                    });
                }
            } catch (e) {}
            $el.not(".escape,.selectize").select2();

            if($is_mobile)
        		$(".select2-search, .select2-focusser").remove();
            }
            addPageHook(function(){
            list_terms();
            currentterm = "";
            return "destroy";
            });
        ';
	}

	function print_list_classes($current_class_group = "", $allowAllClasses = false)
	{
		$classes = $this->get_classes_by_group($allowAllClasses);
		$x = 66;
		echo '
        var currentclassgroup = "', $current_class_group, '";
        var currentclassgroup2 = currentclassgroup;
        var class_group = ', json_encode($classes), ';
        function list_classes(group,cls){
            if(group === undefined)
                var group_id = $("#class_group_id").val();
            else
                var group_id = $("#"+group).val();

            if(cls === undefined)
                 $el = $("#class_id");
            else
                 $el = $("#"+cls);
            try {
                $el.html("");
                if(group_id == "0"){
                    $el.append($("<option></option>")
                                .attr("value", 0).text("All Classes"));
                }else if(group_id == "-1"){
                    $el.append($("<option></option>")
                                .attr("value", "' . c()->passed_out() . '").text("Pass Out"));
                }else{
                    var lop = class_group[group_id];
                    $.each(lop, function (key, value) {
                        if(currentclassgroup == value.class_id){
                            $el.append($("<option selected></option>")
                                .attr("value", value.class_id).text(value.name));
                        }else{
                            $el.append($("<option></option>")
                                .attr("value", value.class_id).text(value.name));
                        }
                    });
                }
            } catch (e) {}
            $el.not(".escape,.selectize").select2();
            }
            jQuery(document).ready(function()
	{
	        addPageHook(function(){
            list_classes();
            currentclassgroup = "";
            return "destroy";
            });
            });
        ';
	}

	function all_access($id = null)
	{
		return all_access($id);
	}

	function convert_permission($perm, $asArray = false)
	{
		$x = explode(",", $perm);
		foreach ($x as &$p) {
			$p = ucwords(str_replace("_", " ", $p));
		}
		return !$asArray ? implode(", ", $x) : $x;
	}

	function isStudent()
	{
		return $this->session->userdata("login_as") == "student";
	}

	function isTeacher($check_is_not_admin = false)
	{
		if ($check_is_not_admin)
			return $this->session->userdata("login_as") == "teacher" && $this->session->userdata("is_admin") == 0;

		return $this->session->userdata("login_as") == "teacher";
	}

	function isAdmin()
	{
		return $this->session->userdata("login_as") == "admin" || $this->session->userdata("is_admin") == 1;
	}

	function isParent()
	{
		return $this->session->userdata("login_as") == "parent";
	}

	function is($login_as, $exact = false)
	{ //admin
		$x = $this->session->userdata("login_as"); //teacher

		if ($login_as == "staff") {
			if ($x == 'teacher' || $x == 'admin')
				return true;
		}

		if ($x == 'teacher' && !$exact) {
			if ($login_as == 'teacher')
				return $this->session->userdata("is_admin") == 0;

			if ($login_as == 'admin')
				return $this->session->userdata("is_admin") == 1;
		}

		return $this->session->userdata("login_as") == $login_as;
	}

	function get_student_form($options = array("required_all" => false))
	{

		//GET CLASS GROUPS
		$class_g = $this->get_class_group();
		$class_group_ids = array();
		foreach ($class_g as $row) {
			$class_group_ids[$row['class_group_id']] = $row['name'];
		}
		$class_group_ids[-1] = "Pass Out";

		//GET PARENTS
		$parent = $this->get("parent")->result_array();
		$parent_id = array();
		foreach ($parent as $row) {
			$parent_id[$row['parent_id']] = $row['name'] . " - " . $row['phone'];
		}

		//SET REQUIRED VALUES
		$required_all = isset($options['required_all']) ? $options['required_all'] : true;

		$except = isset($options['except']) ? explode(",", $options['except']) : array();

		//GET CURRENT CLASS ID AND SET IT
		$current_class = array();
		if (!empty(getIndex($options, 'student,class_id'))) {
			$class_name = $this->get_class_name(getIndex($options, 'student,class_id'));
			if (!empty($class_name)) {
				$current_class[getIndex($options, 'student,class_id')] = $class_name;
			}
		}


		//GET AND SET ADMISSION NUMBER
		$adm = new admission_number();
		$adm_attr = array();
		if ($adm->automatic_generate()) {
			$adm_attr = array("disabled" => 'disabled', "value" => $adm->next_no(false));
		}

		$fields = $this->db->list_fields("student");
		$change = array(
			"student_id" => array("type" => "hidden"),
			"surname" => array("label" => "Surname", "required" => true),
			"fname" => array("label" => "First Name", "required" => true),
			"mname" => array("label" => "Middle Name"),
			"birthday" => array("type" => "text", "attr" => array("class" => "datepicker")),
			"admission_no" => array("type" => "text", "attr" => $adm_attr),
			"parent_id" => array("label" => "Parent", "type" => "select", "options" => $parent_id),
			"sex" => array("type" => "radio", "options" => array("male" => "male", "female" => "female")),
			"lga" => array("label" => "LGA"),
			"password" => array("type" => "password", "attr" => array("class" => "autocomplete-off")),
			"hear_about_us" => array("label" => "How did you get to know about us"),
			"others" => array("label" => "Other Relevant Information"),
			"permanent_address" => array("type" => "textarea"),
			"primary_language" => array("type" => "text"),
			"religion" => array("type" => "select", "options" => array("islam" => "Islam", "christian" => "Christian", "others" => "Others")),
			"last_school" => array("type" => "text", "label" => "Name and Address of Last School Attended"),
			"last_school_duration" => array("type" => "text", "label" => "Duration in last school"),
			"last_school_reason" => array("type" => "text", "label" => "Reason for leaving"),

			"class_id" => array("type" => "select", "label" => "Class", "attr" => array("id" => 'class_id'), "options" => $current_class)

		);

		$skip = array("dormitory_id", "dormitory_room_number", "access", "dirty", "deleted", "rowversion", "transport_id");

		$studentform = array();

		foreach ($fields as $field) {

			if (in_array($field, $skip))
				continue;

			if (isset($options['student'])) {
				$student = $options['student'];
				$studentform[$field]['value'] = isset($student[$field]) ? $student[$field] : "";

			}
			$studentform[$field]['type'] = "text";
			$studentform[$field]['name'] = $field;
			$studentform[$field]['label'] = ucwords(str_replace(array("c1", "c2", "_", "address1", "address2"), array("", "", " ", "Home Address", "Office Address"), $field));

			if ($required_all) {
				$studentform[$field]['required'] = !in_array($field, $except);
			} else {
				$studentform[$field]['required'] = in_array($field, $except);
			}
			if (isset($change[$field])) {
				$row = $change[$field];
				if (isset($row['type'])) {
					$studentform[$field]['type'] = $row['type'];
				}
				if (isset($row['label'])) {
					$studentform[$field]['label'] = $row['label'];
				}
				if (isset($row['options'])) {
					$studentform[$field]['options'] = $row['options'];
				}

				if (isset($row['required'])) {
					$studentform[$field]['required'] = $row['required'];
				}

				if (isset($row['class'])) {
					$studentform[$field]['class'] = $row['class'];
				}

				if (isset($row['attr'])) {
					$studentform[$field]['attr'] = $row['attr'];
				}


			}
		}
		$studentform["class_group_id"] = array("type" => "select", "value" => $this->get_class_group_id(getIndex($options, 'student,class_id')), "label" => "Class Group", "options" => $class_group_ids, "attr" => array("id" => 'class_group_id', 'onchange' => 'list_classes();updateFloatingLabels();'));

		return $studentform;

	}


	function get_teacher_form($options = array("required_all" => false))
	{
		$class = $this->get("class")->result_array();
		$class_ids = array();
		foreach ($class as $row) {
			$class_ids[$row['class_id']] = $row['name'];
		}

		$my_access = $this->all_access();
		foreach ($my_access as $k => $v)
			$my_access[$k] = str_replace("_", " ", ucwords($v));

		$parent = $this->get("parent")->result_array();
		$parent_id = array();
		foreach ($parent as $row) {
			$parent_id[$row['parent_id']] = $row['name'];
		}
		$required_all = isset($options['required_all']) ? $options['required_all'] : true;

		$st = $this->get("teacher_categories")->result_array();
		$staff_c = array();
		foreach ($st as $row)
			$staff_c[$row['category_id']] = ucwords($row['name']);

		$except = isset($options['except']) ? explode(",", $options['except']) : array();

		$adm = new staff_id();
		$adm_attr = array();
		if ($adm->automatic_generate()) {
			$adm_attr = array("disabled" => 'disabled', "value" => $adm->next_no(false));
		}
		$fields = $this->db->list_fields("teacher");
		$change = array(
			"teacher_id" => array("type" => "hidden"),
			"surname" => array("label" => "Surname", "required" => true),
			"fname" => array("label" => "First Name", "required" => true),
			"mname" => array("label" => "Middle Name"),
			"staff_id" => array("label" => "Staff ID", "type" => "text", "attr" => $adm_attr),
			"birthday" => array("type" => "text", "attr" => array("class" => "datepicker")),
			"is_admin" => array("label" => "Login Type", "type" => "select", "options" => array("Staff", "Administrator"), "default" => 0),
			"parent_id" => array("label" => "Parent", "type" => "select", "options" => $parent_id),
			"sex" => array("type" => "radio", "options" => array("male" => "male", "female" => "female")),
			"marital_status" => array("type" => "radio", "options" => array("single", "married")),
			"type_of_employment" => array("type" => "select", "options" => array("permanent", "contract")),
			"is_academic" => array("type" => "select", "options" => array("Non Teaching Staff", "Teaching Staff"), "label" => "Academic Status"),
			"tc" => array("type" => "select", "label" => "Type of Staff", "options" => $staff_c),
			"status" => array("type" => "select", "options" => array("resignation", "termination", "active service", "leave of absence")),
			"profession" => array("type" => "select", "options" => $this->teacher_profession("all")),
			"lga" => array("label" => "LGA"),
			"password" => array("type" => "password", "attr" => array("class" => "autocomplete-off")),
			"address" => array("type" => "textarea"),
			"access" => array("type" => "select", "name" => "access[]", "options" => $my_access, "multiple" => true, "label" => "Specific Access"),
			"religion" => array("type" => "select", "options" => array("muslim" => "Muslim", "christian" => "Christian", "others" => "Others")),

		);
//print_r($change);
		$skip = array("documents", "dormitory_id", "dormitory_room_number", "dirty", "deleted", "rowversion", "transport_id");

		$studentform = array();

		foreach ($fields as $field) {

			if (in_array($field, $skip))
				continue;

			if (isset($options['teacher'])) {
				$student = $options['teacher'];
				$studentform[$field]['value'] = isset($student[$field]) ? $student[$field] : "";
				if ($field == "access") {
					$studentform[$field]['value'] = explode(",", $student[$field]);
					foreach ($studentform[$field]['value'] as $k => $v)
						$studentform[$field]['value'][$k] = str_replace("_", " ", ucwords($v));
				}
			}

			$studentform[$field]['type'] = "text";
			$studentform[$field]['label'] = ucwords(str_replace(array("c1", "c2", "_", "address1", "address2"), array("", "", " ", "Home Address", "Office Address"), $field));
			$studentform[$field]['name'] = $field;
			if ($required_all) {
				$studentform[$field]['required'] = !in_array($field, $except);
			} else {
				$studentform[$field]['required'] = in_array($field, $except);
			}

			if (isset($change[$field])) {
				$row = $change[$field];
				if (isset($row['type'])) {
					$studentform[$field]['type'] = $row['type'];
				}
				if (isset($row['label'])) {
					$studentform[$field]['label'] = $row['label'];
				}
				if (isset($row['options'])) {
					$studentform[$field]['options'] = $row['options'];
				}

				if (isset($row['required'])) {
					$studentform[$field]['required'] = $row['required'];
				}

				if (isset($row['multiple'])) {
					$studentform[$field]['multiple'] = $row['multiple'];
				}

				if (isset($row['name'])) {
					$studentform[$field]['name'] = $row['name'];
				}

				if (isset($row['default']) && !isset($studentform[$field]['value'])) {
					$studentform[$field]['value'] = $row['default'];
				}

				if (isset($row['attr'])) {
					$studentform[$field]['attr'] = $row['attr'];
				}

			}


		}
		return $studentform;

	}


	function create_input($options)
	{
		$name = isset($options['name']) ? $options['name'] : "";
		$label = isset($options['label']) ? $options['label'] : "Value";

		$attr_ = isset($options['attr']) ? $options['attr'] : array();

		$attr_['class'] = empty($attr_['class']) ? "form-control" : $attr_['class'] . " form-control";

		$attr = "";


		$type = isset($options['type']) ? $options['type'] : "text";
		$value = isset($options['value']) ? $options['value'] : "";

		$showclass = isset($options['showclass']) ? $options['showclass'] : "text-warning";
		$required = isset($options['required']) && $options['required'] ? "data-validate='required' data-message-required='$label Required'" : "";
		$op = isset($options['options']) ? $options['options'] : array();
		$onlyshow = isset($options['onlyshow']) ? $options['onlyshow'] : false;

//        if($type == 'select')
//            $attr_['class'] .= " escape";


		//SHOW ONLY
		if ($onlyshow) {
			$attr_['disabled'] = 'disabled';
			$show = $value;
			if ($type == "select" || $type == "radio" || $type == "checkbox") {
				$show = "";
				if ($type == 'select' && isset($options['multiple']) && $options['multiple']) {
					$s = array();
					foreach ($op as $k => $v) {
						if (is_array($value)) {
							if (in_array($v, $value)) $s[] = $v;
						} else
							if (strtolower($k) == strtolower($value)) $s[] = $v;
					}
					$show = implode(", ", $s);

				} else {
					foreach ($op as $k => $v) {
						if ($k == $value) {
							$show = ucwords($v);
							break;
						}

					}
				}

			}

			if ($type == "password") {
				$show = "*********";
			}

			if ($type == "image") {
				$options['type'] = $options['type_'];
				return $this->construct_image($options);
			}

			$attr = extract_attr($attr_);

			if ($type == 'textarea') {
				return "<textarea $attr class='form-control' >$show</textarea>";
			}

			if (strpos(getIndex($attr_, 'class'), "datepicker") !== false) {
				$show = empty($show) ? "" : date(dateFormat(), $show);
			}

			$show = pv($show);
			return "<input value='$show' $attr class='form-control' style='border: none; color: #4e1c1c;'>";
		}

		//SHOW ALL INPUTS
		$value = is_array($value) ? $value : htmlspecialchars($value);

		$attr = extract_attr($attr_);
		if ($type == "textarea") {
			return "<textarea $attr rows='4' name='$name' $required>$value</textarea>";
		}

		if ($type == "select") {
			$multiple = false;
			if (isset($attr_['multiple']) && $attr_['multiple']) {
				$multiple = true;
			}

			$attr = extract_attr($attr_);
			$str = "<select $attr  $required name='$name'>";
			if ($multiple) {
				$str .= "<option value=''>Select $label</option>";
			}
			$str .= "";
			foreach ($op as $k => $v) {
				if (is_array($value)) {
					$s = in_array($v, $value) ? "selected" : "";
				} else
					$s = strtolower($k) == strtolower($value) ? "selected" : "";

				$str .= "<option $s value='$k'>" . ucwords($v) . "</option>";
			}
			$str .= "</select>";
			return $str;
		}

		if ($type == "checkbox" || $type == "radio") {
			$str = "<div>";
			$name = $name . "";
			if(empty($op)){
				$op = array("Allow Reseller");
			}

			foreach ($op as $v) {
				$v1 = ucwords($v);
				$s = $v == $value ? "checked=checked" : "";
				$str .= "
 <label class='radio-inline radio-secondary'>
							<input $required type='$type' name='$name' value='$v' $attr $s> $v1
                        </label>

";
			}
			return $str . "</div>";
		}


		if ($type == "password") {
			$width = 70;
			if ($value == "") {
				$width = 100;
			}
			return "<input $attr style='width: $width%; display: inline-block' " . ($value == "" ? "" : "disabled='disabled'") . " type='$type'
 value='" . (empty($value) ? "" : "**********") . "'
name='$name'
id='$name' $required >" . ($value == "" ? "" : "<input style='width: 29%; margin-left: 1%; display: inline-block; '
type='button'
class='btn btn-success' onclick=\"$('#$name').removeAttr('disabled').val('').attr('required','required');\"
value='change'>");
		}

		if ($type == "image") {
			$options['type'] = $options['type_'];
			return $this->construct_image($options);
		}

		if (strpos(getIndex($attr_, 'class'), "datepicker") !== false) {
			if (strlen($value) > 5) {
				$value = date("d/m/Y", $value);
			} else {
				$value = "";
			}
			return "<input $attr type='$type' value='$value' name='$name' id='$name'

$required >";
		}

		return "<input $attr type='$type' value='$value' name='$name' id='$name'

$required >";
	}

	function app2student_id($appid)
	{
		return (int)str_replace("app-", "", strtolower($appid));
	}

	function app_id($student_id)
	{
		return "APP-" . $student_id;
	}

	function get_full_name($row, $owner = null)
	{
		if (empty($row)) {
			return "";
		}

		if (is_string($row) || is_numeric($row)) {
			$row = $this->get_user($row);
		}

		$row = (array)$row;

		$x = "";

		foreach (default_login_column(null,"", $owner) as $column) {
			if (!empty($row[$column]) && $row[$column] != "") {
				if($column == "phone"){
					$x = filter_numbers($row[$column], true, "national");
				}else
					$x = $row[$column];
				break;
			}
		}

		return $x;

		if (isset($row['name']))
			return ucwords($row['name']);

		return $row['email'];
		if ($include_id)
			return $this->get_staff_student_id($row) . " - " . ucwords(getIndex($row, 'surname') . " " . $row['fname']); //." ".$row['mname']);

		return ucwords(getIndex($row, 'surname') . " " . $row['fname']);//." ".$row['mname']);
	}

	function get_user_type($row)
	{
		$x = "student,teacher,admin,parent";
		$array = explode(",", $x);

		if (is_string($row)) {
			$first = strtolower(substr($row, 0, 1));
			$table = null;
			foreach ($array as $k => $v) {
				if (strpos($v, $first) === 0) {
					return $v;
				}
			}
			foreach ($array as $k => $tb) {
				$key = $this->tables($tb, true)->primary_key;
				$rs = $this->get_where($tb, $key, $row);
				if ($rs->num_rows() > 0)
					return $tb;
			}
		} else {
			$row = (Array)$row;
			foreach ($array as $k => $v) {
				if (isset($row[$v . "_id"]))
					return $v;
			}
		}

		return "";
	}


	function get_staff_student_id($row)
	{
		$row = (Object)$row;
		if (isset($row->teacher_id)) {
			return $row->staff_id;
		}
		if (isset($row->admission_no)) {
			return $row->admission_no;
		}

		return "";
	}

	function get_short_name($row)
	{
		if (is_object($row)) {
			if (!isset($row->surname)) {
				return ucwords($row->name);
			}
			return ucwords($row->surname . ", " . $this->short_name($row->fname) . $this->short_name($row->mname));
		}
		if (!isset($row['surname']))
			return ucwords($row['name']);

		return ucwords($row['surname'] . ", " . $this->short_name($row['fname']) . $this->short_name($row['mname']));
	}

	function short_name($name)
	{
		if (strlen($name) > 0)
			return strtoupper($name[0]) . ".";
		return "";

	}

	function teacher_profession($id)
	{
		$p = get_arrange_id_name("teacher_profession", "profession_id");
		if ($id != "all") {
			return getIndexOf($p, "$id", "name");;
		}
		return $p;
	}

	function get_session($term_id, $column_name = "")
	{
		$row = $this->get_where("term", array("term_id" => $term_id));
		if ($row->num_rows() > 0) {
			$year_id = $row->row()->year_id;
			if (empty($column_name))
				return $year_id;

			return $this->get_row("year", "year_id", $year_id, $column_name);
		}
		return "";
	}

	function get_nth_term($session_id, $term_no = "1")
	{
		d()->where("year_id", $session_id);
		d()->order_by("start", "ASC");
		$array = $this->get("term")->row_array($term_no - 1);
		return getIndexOf($array, "term_id");
	}


	function get_last_term($session_id)
	{
		d()->where("year_id", $session_id);
		d()->order_by("start", "DESC");
		$array = $this->get("term")->row_array();
		return getIndexOf($array, "term_id");
	}

	function get_first_term($session_id)
	{
		d()->where("year_id", $session_id);
		d()->order_by("start", "ASC");
		$array = $this->get("term")->row_array();
		return getIndexOf($array, "term_id");
	}

	function get_session_term($term_id)
	{
		$row = $this->get_where("term", array("term_id" => $term_id));
		$term = array();
		$session = array();

		if ($row->num_rows() > 0) {
			$term = $row->row_array();
			$session = $this->get_row("year", "year_id", $term['year_id']);
		}
		return array("session" => $session, "term" => $term);
	}

	function get_sessions($by_id = false)
	{
		$this->order_by("name_numeric", "ASC");
		$row = $this->get("year")->result_array();
		if ($by_id) {
			return get_arrange_id($row, "year_id");
		}
		return $row;
	}

	function get_class_group_id($class_id)
	{
		if (empty($class_id)) {
			return "";
		}
		if ($class_id == c()->passed_out())
			return -1;

		$row = $this->get_where("class", array("class_id" => $class_id));
		if ($row->num_rows() > 0) {
			return $row->row()->class_group_id;
		}
		return "";
	}


	function get_class_group_row($class_id)
	{
		$row = $this->get_where("class", array("class_id" => $class_id));
		$class = array();
		$cls_grp = array();

		if ($row->num_rows() > 0) {
			$class = $row->row_array();
			$cls_grp = $this->get_row("class_group", "class_group_id", $class['class_group_id']);
		}
		return array("class_group" => $cls_grp, "class" => $class);
	}

	function detail_exit($detail, $where = "email", $andid = "", $allowempty = false)
	{
		$credential = array($where => $detail);


		if (empty($detail)) {
			return !$allowempty;
		}

		// Checking login credential for admin
		if ($andid != "") $this->where('admin_id !=', $andid);
		$query = $this->get_where('admin', $credential);
		if ($query->num_rows() > 0) {
			return true;
		}

		// Checking login credential for teacher
		if ($andid != "") $this->where('teacher_id !=', $andid);
		$query = $this->get_where('teacher', $credential);
		if ($query->num_rows() > 0) {
			return true;
		}

		// Checking login credential for student
		if ($andid != "") $this->where('student_id <>', $andid);
		$query = $this->get_where('student', $credential);
		if ($query->num_rows() > 0) {
			return true;
		}

		// Checking login credential for parent
		if ($andid != "") $this->where('parent_id !=', $andid);
		$query = $this->get_where('parent', $credential);
		if ($query->num_rows() > 0) {
			return true;
		}

		return false;
	}

	function is_email($email)
	{
		return !(filter_var($email, FILTER_VALIDATE_EMAIL) === false);
	}

	function get_option_type($value = "")
	{
		$x = array("Today", "This Week", "This Month", "This Term", "This Session", "Specific Date");
		if ($value == "")
			return $x;
		return indexOf($value, $x);
	}

	function get_view_type2($value = "")
	{
		$x = array("SMS", "Emails");
		if ($value == "")
			return $x;
		return indexOf($value, $x);
	}


	function get_options($page_name, $value = "")
	{
		if ($page_name == "invoice")
			$x = array("No Time Specified", "Today", "This Week", "This Month", "Specific Date");

		if ($page_name == "invoice_status")
			$x = array("All", "Paid", "Unpaid");

		if ($page_name == "expense_category") {
			$y = $this->get("expense_category")->result_array();
			$x = array("All");
			foreach ($y as $v) {
				$x[$v['expense_category_id']] = $v['name'];
			}
		}

		if ($value == "")
			return $x;
		return indexOf($value, $x);
	}


	function get_attendance($mtype, $term_id, $type = "This Term", $startdate = "", $enddate = "")
	{
		$atd = array();

		if ($mtype == 'student') {
			$table = "attendance";
			$myid = 'student_id';
		} else {
			$table = "attendance_staff";
			$myid = 'teacher_id';
		}

		if ($this->get_option_type("today") == $type) {
			$startdate = date("Y/m/d");
			$enddate = date("Y/m/d");
		}

		if ($this->get_option_type("this week") == $type) {
			$monday = strtotime('last monday', strtotime('tomorrow'));
			$startdate = date("Y/m/d", $monday);
			$enddate = date("Y/m/d");
		}

		if ($this->get_option_type("this month") == $type) {
			$startdate = date("Y/m") . "/01";
			$enddate = date("Y/m/d");
		}

		d()->order_by("date", "ASC");

		if ($this->get_option_type("this term") == $type) {
			$query = $this->get_where($table, "term_id", $term_id)->result_array();
		} else {
			$this->where("date >=", database_date($startdate));
			$this->where("date <", database_date($enddate, 86400));
			$query = $this->get_where($table, "term_id", $term_id)->result_array();
		}

		$date = array();
		$total = array();
		foreach ($query as $row) {
			$status = $row['status'] == 1 ? 1 : 0;
			$atd[$row['date']][$row['period']][$row[$myid]] = $status;

			if (!in_array($row['date'], $date))
				$date[] = $row['date'];


			$total[$row[$myid]] = isset($total[$row[$myid]]) ? $total[$row[$myid]] + $status : $status;
			$max_total[$row[$myid]] = isset($max_total[$row[$myid]]) ? $max_total[$row[$myid]] + 1 : 1;
		}

		return array("dates" => $date, "attendance" => $atd, "total" => $total, "max" => max(empty($max_total) ? array(0) : $max_total));
	}

	function preschool_heading_type($type)
	{
		if ($type == 1)
			return Array(3 => "ALWAYS", 2 => "SOMETIMES", 1 => "NEVER");
		else
			return Array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1);
	}


	public $template_name = "default";

	function get_template_settings($name, $default = "")
	{
		return get_setting("theme_" . $this->template_name . "_$name", $default);
	}

	function set_template_settings($name, $value)
	{
		return set_setting("theme_" . $this->template_name . "_$name", $value);
	}


	function get_template_image_url($name)
	{
		return c()->get_image_url("theme_images", "$this->template_name" . "_$name");
	}

	function replace_values($text, $member, $addition = array(), $bracket = array("[", "]"))
	{

		$x = $bracket[0];
		$y = $bracket[1];

		foreach ($addition as $key => $value) {
			$text = str_ireplace("$x$key$y", $value, $text);
		}

		if (!empty($member)) {
			$ex = explode("-", $member);
			if (count($ex) != 2)
				return $text;

			d()->where($ex[0] . "_id", $ex[1]);
			$z = c()->get($ex[0]);

			if ($z->num_rows() > 0) {
				$fields = $z->row_array();

				foreach ($fields as $key => $value) {
					if (empty($value))
						$value = "";
					$text = str_ireplace($x . $key . $y, $value, $text);
				}
			}
		}


		return $text;
	}

	function send_mail($message, $subject, $to, $customer = "", $from = null, $save = true)
	{
		if ($message == "")
			return "";

		$x = $this->email_model->do_email($message, $subject, $to, $from);
		$staff_id = is('admin') || is('teacher') ? login_as_id() : 0;
		if ($save) {
			$data['staff_id'] = $staff_id;
			$data['user_id'] = $customer;
			$data['subject'] = $subject;
			$data['message'] = $message;
			$data['recipients'] = $to;
			$data['status'] = "Sent";
			$data['date'] = gdate();
			$data['term_id'] = get_setting("current_term");
			$this->insert("sent_mail", $data, 'id');
		}
		return $x;
	}

	function lesson_properties()
	{
		$x = "differentiation,prior_learning,topic,starter,differentiated,all_will,most_will,some_will,key_words,resources,activities,diff,sign_posts,plenary,home_work";
		return explode(",", $x);
	}

	function lesson_access()
	{
		$x = "update_lesson_plan,delete_lesson_plan,add_lesson_comment,delete_lesson_comment";
		return explode(",", $x);
	}

	function allowedScript()
	{
		$x = "lesson_plan/create";
		return explode(",", $x);
	}

	function send_sms($message, $sender_id, $to, $customer = "", $save = true)
	{
		if ($message == "")
			return false;


		$result = $this->sms_model->send_sms($message, $to, $sender_id, $customer, $save);

		return $result;
	}

	function get_attendance_period($id = '')
	{
		$x = array(1 => "Morning", 2 => "Afternoon");
		if ($id == '') {
			return $x;
		}
		return getIndex($x, $id);
	}

	function get_permissions($role_id, $is_role_id = true)
	{
		if ($is_role_id) {
			$row = $this->get_row("role", "id", $role_id);
			$access = getIndex($row, "access");
		} else {
			$access = $role_id;
		}

		if (empty($access))
			return "";


		$x = explode(",", $access);
		$menu = new MenuBuilder();
		$acc = get_arrange_id_name($menu->get_menu(true), "access", "access");

		$y = array();
		$y[] = "login";
		foreach ($x as $v)
			$y[] = getIndex($acc, $v);
		return implode(",", $y);
	}

	function get_notifications()
	{
		$x['label'] = "Registration Message";
		$x['options'][] = string2array("name=registration_mail_title,type=text");
		$x['options'][] = string2array("name=registration_mail,type=textarea,attr=class=summernote|data-height=100px|data-width=100%");
		$x['options'][] = string2array("name=registration_mail_enabled,type=select,options=0=disabled|1=enabled");
		$x['options'][] = string2array("name=registration_sms_title,type=text");
		$x['options'][] = string2array("name=registration_sms,type=textarea");
		$x['options'][] = string2array("name=registration_sms_enabled,type=select,options=0=disabled|1=enabled");
		$array[] = $x;

		$x = array();
		$x['label'] = "Fund Wallet Message";
		$x['options'][] = string2array("name=fund_wallet_mail_title,type=text");
		$x['options'][] = string2array("name=fund_wallet_mail,type=textarea,attr=class=summernote|data-height=100px|data-width=100%");
		$x['options'][] = string2array("name=fund_wallet_mail_enabled,type=select,options=0=disabled|1=enabled");
		$x['options'][] = string2array("name=fund_wallet_sms_title,type=text");
		$x['options'][] = string2array("name=fund_wallet_sms,type=textarea");
		$x['options'][] = string2array("name=fund_wallet_sms_enabled,type=select,options=0=disabled|1=enabled");
		$array[] = $x;

		$x = array();
		$x['label'] = "Password Reset Message";
		$x['options'][] = string2array("name=password_reset_mail_title,type=text");
		$x['options'][] = string2array("name=password_reset_mail,type=textarea,attr=class=summernote|data-height=100px|data-width=100%");
		$x['options'][] = string2array("name=password_reset_mail_enabled,type=select,options=0=disabled|1=enabled");
		$x['options'][] = string2array("name=password_reset_sms_title,type=text");
		$x['options'][] = string2array("name=password_reset_sms,type=textarea");
		$x['options'][] = string2array("name=password_reset_sms_enabled,type=select,options=0=disabled|1=enabled");
		$array[] = $x;

		$x = array();
		$x['label'] = "Missed You Message";
		$x['options'][] = string2array("name=missed_you_mail_title,type=text");
		$x['options'][] = string2array("name=missed_you_mail,type=textarea,attr=class=summernote|data-height=100px|data-width=100%");
		$x['options'][] = string2array("name=missed_you_mail_day,type=text");
		$x['options'][] = string2array("name=missed_you_mail_enabled,type=select,options=0=disabled|1=enabled");
		$x['options'][] = string2array("name=missed_you_sms_title,type=text");
		$x['options'][] = string2array("name=missed_you_sms,type=textarea");
		$x['options'][] = string2array("name=missed_you_sms_day,type=text");
		$x['options'][] = string2array("name=missed_you_sms_enabled,type=select,options=0=disabled|1=enabled");
		$array[] = $x;
		return $array;
	}

	function process_notification($message, $user_id = "", $owner = null)
	{
		$owner = !empty($owner) ? $owner : owner;
		$user_id = !empty($user_id) ? $user_id : login_id();

		$array = user_data(null,$user_id, array());
		if (!empty($array)) {
			foreach ($array as $col => $value) {
				if ($col == "rate" || $col == "dnd_rate")
					continue;
				if($col == "username"){
					$message = str_ireplace("@@{$col}@@", $this->get_full_name($user_id), $message);
				}else{
					$message = str_ireplace("@@{$col}@@", $value, $message);
				}
			}
		}


		$rate_array = array("rate", "dnd_rate");
		$sms = new sms($owner);
		$sms->set_user($user_id);

		foreach ($rate_array as $value) {
			if (stripos($message, "@@{$value}@@") !== false) {
				$rate = $sms->get_display_rate($value=="dnd_rate"?true:false);
				$rep = "";
				$national = getIndex($rate, "national", array());
				foreach ($national as $network => $price) {
					if ($network == 'all') {
	                    $network = (count($national)==1?"All":"Other"). " Network";
					} else {
						$network = strtoupper($network);
					}
                   $rep .= $network." ".format_wallet($price)."<br>";
				}

				$message = str_ireplace("@@{$value}@@", $rep, $message);

			}

		}

		$others = array("site_name","website","cemail","cphone","caddress");

		foreach($others as $value){
			$message = str_replace("@@{$value}@@", get_setting($value,"",$owner), $message);
		}

		return $message;

	}

	function send_sms_notification($notification_type, $to, $replace=array(), $user_id = null, $route = 1, $charge = false, $owner = null){
		return $this->send_notification($notification_type."_sms",$to,$route,$replace,$charge,$user_id,$owner);
	}

	function send_mail_notification($notification_type, $to, $replace=array(), $user_id=null,$owner=null){
		return $this->send_notification($notification_type."_mail",$to,true,$replace,false,$user_id,$owner);
	}
	function send_notification($notification, $to, $for_mail_or_route = true, $replace = array(), $charge=false, $user_id = "", $owner = ""){
		if(empty($to)){
			return false;
		}
		$owner = !empty($owner) ? $owner : owner;
		$user_id = !empty($user_id) ? $user_id : login_id();

		$title = setting()->get_notification("{$notification}_title");
		$message = setting()->get_notification("{$notification}");

		if(empty(setting()->get_notification("{$notification}_enabled")))
			return false;

		if(!empty($message) && !empty($title)){
			foreach($replace as $key => $value){
				$message = str_ireplace("@@{$key}@@", $value, $message);
				$title = str_ireplace("@@{$key}@@", $value, $title);
			}
			$message = c()->process_notification($message, $user_id, $owner);
			$title = c()->process_notification($title, $user_id, $owner);
			if($for_mail_or_route === true){
				if(!$this->is_email($to)){
					return false;
				}
				send_mail($message, $title, $to);
				return true;
			}else{
				return send_sms($message, $title, $to, $for_mail_or_route, $user_id, $owner, $charge);
			}
		}

		return false;
	}

	function mark_notification($nt_id, $type= "read", $user_id = null){
		if(empty($user_id))
			$user_id = login_id();

		c()->where("notification_id", $nt_id);
		c()->where("user_id", $user_id);
		$row = c()->get("notification_read")->row_array();

		if($type == "read"){
			$data['read_date'] = time();
		}else{
			$data['view_date'] = time();
		}

		if(empty($row)){
			$data['notification_id'] = $nt_id;
			$data['user_id'] = $user_id;
			c()->insert("notification_read", $data);
		}else{
			if($type == "read" && $row['read_date'] > 0){
				return;
			}else if($type == "viewed" && $row['view_date'] > 0){
				return;
			}
			d()->where("id", $row['id']);
			c()->update("notification_read", $data);
		}
	}

	function is_notification_read($nt_id, $user_id = null){
		if(empty($user_id))
			$user_id = login_id();

		c()->where("notification_id", $nt_id);
		c()->where("user_id", $user_id);
		$row = c()->get("notification_read")->row_array();

		if(empty($row)){
			return false;
		}else{
			return true;
		}
	}

	function show_notification($page_name, $type = 1){
		$name = $this->notification_page_name($page_name);
		$user_id = login_id();
		$registration_date = user_data("registration_date");

//		d()->where("notification.owner", owner);
////		d()->where("user_id !=", $user_id);
////		d()->where("notification_read.id", null);
//		d()->join("notification_read", "notification.id = notification_read.notification_id", "left");
//		d()->select("*");
//		d()->group_by("notification_id");
//		d()->select("notification.id as id");
//		$array = d()->get("notification")->result_array();
		$array = d()->query("select * from notification where id not in (select notification_id from notification_read where user_id = $user_id and notification.id = notification_id)")->result_array();
		if(!empty($array)){
			foreach($array as $row){
				$data['notification_id'] = $row['id'];
				$data['user_id'] = $user_id;
				c()->insert("notification_read", $data);
			}
		}

		if($type !=  "homepage")
			d()->where("notification.type", $type);

		d()->where("notification.owner", owner);
		d()->group_start();
			d()->group_start();
				d()->where("notification.new_user_can_see", 0);
				d()->where("notification.date >", $registration_date);
			d()->group_end();

			d()->or_group_start();
				d()->where("notification.new_user_can_see", 1);
			d()->group_end();
		d()->group_end();

		if($name == "all"){
			d()->where("location", "all");
		}else if($type != "homepage"){
			d()->group_start();
				d()->like("location", "[{$name}]");
				d()->or_where("location", "all");
			d()->group_end();
		}else if($type == "homepage"){
			d()->like("location", "[{$name}]");
		}

		d()->where("active", 1);
		d()->where("user_id", $user_id);

		d()->group_start();
			d()->where("expires", 0);
			d()->or_where("expires >", time());
		d()->group_end();


		d()->group_start();
			d()->group_start();
				d()->where("view_date", 0);
			d()->group_end();


			d()->or_group_start();
				d()->where("show_once", 0);
				d()->where("disappear_on_read", 1);
				d()->where("notification_read.read_date", 0);
			d()->group_end();


			d()->or_group_start();
				d()->where("show_once", 0);
				d()->where("disappear_on_read", 0);
			d()->group_end();

		d()->group_end();

		d()->order_by("date", "ASC");
		d()->join("notification_read", "notification.id = notification_read.notification_id");
		d()->select("*");
		d()->select("notification.id");
		$array = d()->get("notification")->row_array();
//		print_r($array);
//		if($type == 2)
//		exit;
//		print_r($array);
		return $array;
		print d()->get_compiled_select("notification");
		exit;

	}
//<option  value="hp">Home Page (Login or Not)</option>
//<option value="db">Dashboard</option>
//<option value="sbs">Send Bulk SMS</option>
//<option  value="sbsa">Send Bulk SMS (After Message Sent)</option>
//<option  value="ra">Recharge Account</option>
//<option value="ba">Buy Airtime</option>
//<option  value="bd">Buy Databundle</option>
//<option  value="pb">Pay Bills</option>
	function notification_page_name($page_name){
		switch($page_name){
			case "homepage": return "hp";
			case "dashboard": return "db";
			case "message/bulksms": return "sbs";
			case "wallet/fund": return "ra";
			case "bill/buy_airtime": return "ba";
			case "bill/buy_dataplan": return "bd";
			case "bill/buy_bill": return "pb";
		}
		return "all";
	}
}
