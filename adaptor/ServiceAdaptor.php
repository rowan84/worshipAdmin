<?php
	include_once(__DIR__ . '/../model/Service.php');
	include_once(__DIR__ . '/../dao/GSSSongDAO.php');
	//include('simplehtmldom/simple_html_dom.php');
	class ServiceAdaptor
	{
		
		public function __construct()
		{
			//do nothing
		}
		public function createService($row)
		{	
			$service = new Service();
			$service->date = $row->{'gsx$_cn6ca'}->{'$t'};
			$service->morningEvening = $row->{'gsx$morningevening'}->{'$t'};
			$service->guitarSongBookLink  = $row->{'gsx$guitarchordsongbook'}->{'$t'};
			$service->leadSongBookLink= $row->{'gsx$leadsheetsongbook'}->{'$t'};
			$service->pianoSongBookLink = $row->{'gsx$pianosheetmusicsongbook'}->{'$t'};
			$service->lyricsSongBookLink = $row->{'gsx$lyricssongbook'}->{'$t'};
			for($i = 1; $i <=10; $i++)
			{
				try
				{
					self::addSongToList($i, $row, $service);
				}catch(Exception $e)
				{
					//TODO log error message. 
				}
			}
			
			return $service;
		}
		
		private function getSongCodeFromCodeAndName($songCodeAndName)
		{
			if($songCodeAndName == null || $songCodeAndName == "")
				return null;
			
			$codeAndName =  explode("-", $songCodeAndName);
			return $codeAndName[0];
		}
		
		private function addSongToList($songNumber, $row, $service)
		{
			$songCode = self::getSongCodeFromCodeAndName($row->{'gsx$song'.$songNumber}->{'$t'});
			if($songCode != null)
			{
				$songdao = new GSSSongDAO();
				$song = $songdao->getSong($songCode);
				if($song != null)
				{
					$service->addSong($song);
				}
			}
		}
	}
?>