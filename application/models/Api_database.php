<?php
Class Api_Database extends CI_Model {

	public function get_demand_sources($demandSourceId) {
		//$condition = "is_Active =0";
		$this->db->select('*');
		$this->db->from('tbl_demand_sources');
		$this->db->join('tbl_advertiser','tbl_advertiser.advertiserId=tbl_demand_sources.advertiser');
		$this->db->where("tbl_demand_sources.demand_source_id=".$demandSourceId);
		$query = $this->db->get();
	
		if ($query->num_rows()>0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function checkExistingOffer_db($advertOfferId) {
		$oldRecord=array();
		$condition = "advertiser_offer_id =".$advertOfferId;
		$this->db->select('*');
		$this->db->from('tbl_offer');
		$this->db->where($condition);
		$query = $this->db->get();
		
		if ($query->num_rows()> 0) {
			$oldRecord['isexist']=true;
			$oldRecord['oldOfferData']=$query->row_array();
		}else{
			$oldRecord['isexist']=false;
		}	
		return $oldRecord;
	}
	// Insert demand_source data in database
	public function addTolocalDb($offerTolocalAdd) {
		
		$queryInsetTolocatDb = 'INSERT INTO tbl_offer(affise_offer_id, advertiser_offer_id, title, advertiser, url, url_preview, trafficback_url, domain_url, description, stopDate, countries, creativeFiles, sources, logo, status, freshness, privacy, is_top, payments, partner_payments, total_cap, total_cap_start_date, daily_cap, daily_cap_partner, daily_cap_partners, landings, strictly_country, strictly_os, hold_period, categories, action_status_url, notes, allowed_ip, allow_deeplink, hide_referer, start_at, send_emails, is_redirect_overcap, hide_paments, sub_account_1, sub_account_2, sub_account_1_except, sub_account_2_except) VALUES';
		$Addvals='';
		foreach($offerTolocalAdd as $offerTolocal){
			if($Addvals!=''){
				$Addvals=$Addvals.',('.$offerTolocal->affiseofferid.','.$offerTolocal->id.',"'.urlencode($offerTolocal->name).'","'.$offerTolocal->advertiser.'","'.urlencode($offerTolocal->trackingUrl).'","'.urlencode($offerTolocal->previewUrl).'","","","'.urlencode($offerTolocal->description).'","","'.implode("|",$offerTolocal->countries).'","","Art Of Click","","stopped","","","","'.$offerTolocal->payout.'","","","","'.urlencode($offerTolocal->dailyCap).'","","","","","'.implode("|",$offerTolocal->os).'","","","","","","","","","","","","","","","")';
			}else{
				$Addvals=$Addvals.'('.$offerTolocal->affiseofferid.','.$offerTolocal->id.',"'.urlencode($offerTolocal->name).'","'.$offerTolocal->advertiser.'","'.urlencode($offerTolocal->trackingUrl).'","'.urlencode($offerTolocal->previewUrl).'","","","'.urlencode($offerTolocal->description).'","","'.implode("|",$offerTolocal->countries).'","","Art Of Click","","stopped","","","","'.$offerTolocal->payout.'","","","","'.urlencode($offerTolocal->dailyCap).'","","","","","'.implode("|",$offerTolocal->os).'","","","","","","","","","","","","","","","")';
			}
		}
		$queryInsetTolocatDb=$queryInsetTolocatDb.$Addvals;
		
		$result = $this->db->query($queryInsetTolocatDb);
		return $result;
	}
	public function updateTolocalDb($offerTolocalForEdit) {
		
		$queryInsetTolocatDbEdit = 'INSERT INTO tbl_offer(id,affise_offer_id, advertiser_offer_id, title, advertiser, url, url_preview, trafficback_url, domain_url, description, stopDate, countries, creativeFiles, sources, logo, status, freshness, privacy, is_top, payments, partner_payments, total_cap, total_cap_start_date, daily_cap, daily_cap_partner, daily_cap_partners, landings, strictly_country, strictly_os, hold_period, categories, action_status_url, notes, allowed_ip, allow_deeplink, hide_referer, start_at, send_emails, is_redirect_overcap, hide_paments, sub_account_1, sub_account_2, sub_account_1_except, sub_account_2_except) VALUES';
		$Addvals='';
		$queryUpdateTolocatDb=' ON DUPLICATE KEY UPDATE ';
		$Updatevals='';
		foreach($offerTolocalForEdit as $offerTolocalEdit){
			if($Addvals!=''){
				$Addvals=$Addvals.',('.$offerTolocalEdit->oldid.','.$offerTolocalEdit->affiseofferid.','.$offerTolocalEdit->id.',"'.urlencode($offerTolocalEdit->name).'","'.$offerTolocalEdit->advertiser.'","'.urlencode($offerTolocalEdit->trackingUrl).'","'.urlencode($offerTolocalEdit->previewUrl).'","","","'.urlencode($offerTolocalEdit->description).'","","'.implode("|",$offerTolocalEdit->countries).'","","Art Of Click","","stopped","","","","'.$offerTolocalEdit->payout.'","","","","'.urlencode($offerTolocalEdit->dailyCap).'","","","","","'.implode("|",$offerTolocalEdit->os).'","","","","","","","","","","","","","","","")';
			}else{
				$Addvals=$Addvals.'('.$offerTolocalEdit->oldid.','.$offerTolocalEdit->affiseofferid.','.$offerTolocalEdit->id.',"'.urlencode($offerTolocalEdit->name).'","'.$offerTolocalEdit->advertiser.'","'.urlencode($offerTolocalEdit->trackingUrl).'","'.urlencode($offerTolocalEdit->previewUrl).'","","","'.urlencode($offerTolocalEdit->description).'","","'.implode("|",$offerTolocalEdit->countries).'","","Art Of Click","","stopped","","","","'.$offerTolocalEdit->payout.'","","","","'.urlencode($offerTolocalEdit->dailyCap).'","","","","","'.implode("|",$offerTolocalEdit->os).'","","","","","","","","","","","","","","","")';
			}
		}
		$Updatevals=$Updatevals.'id=values(id),affise_offer_id=values(affise_offer_id),advertiser_offer_id=values(advertiser_offer_id),title=values(title),advertiser=values(advertiser),url=values(url),url_preview=values(url_preview),trafficback_url=values(trafficback_url),domain_url=values(domain_url),description=values(description),stopDate=values(stopDate),countries=values(countries),creativeFiles=values(creativeFiles),logo=values(logo),sources=values(sources),status=values(status),freshness=values(freshness),privacy=values(privacy),payments=values(payments),partner_payments=values(partner_payments),is_top=values(is_top),total_cap=values(total_cap), total_cap_start_date=values(total_cap_start_date),daily_cap=values(daily_cap),daily_cap_partner=values(daily_cap_partner),daily_cap_partners=values(daily_cap_partners), landings=values(landings), strictly_country=values(strictly_country), strictly_os=values(strictly_os), hold_period=values(hold_period), categories=values(categories), action_status_url=values(action_status_url), notes=values(notes), allowed_ip=values(allowed_ip), allow_deeplink=values(allow_deeplink), hide_referer=values(hide_referer), start_at=values(start_at), send_emails=values(send_emails), is_redirect_overcap=values(is_redirect_overcap), hide_paments=values(hide_paments), sub_account_1=values(sub_account_1), sub_account_2=values(sub_account_2), sub_account_1_except=values(sub_account_1_except), sub_account_2_except=values(sub_account_2_except)';
		$queryInsetTolocatDbEdit=$queryInsetTolocatDbEdit.$Addvals.$queryUpdateTolocatDb.$Updatevals;
		$resultUpdate = $this->db->query($queryInsetTolocatDbEdit);
		return $resultUpdate;
	}
	public function updateTolocalDbAffiseDelete($deletedOffersFromAffise) {
		
		$queryTodleteFromLocal = 'update tbl_offer set deletedFromAffise=1 where id in('.implode(",",$deletedOffersFromAffise).')';
		$resultUpdateForDelted = $this->db->query($queryTodleteFromLocal);
		return $resultUpdateForDelted;
	}
	public function deleteFromLocal($allOffersFromAdvertiser) {
		
		$queryTodeleteFromLocal = 'delete from tbl_offer  where advertiser_offer_id NOT IN('.implode(",",$allOffersFromAdvertiser).')';
		$resultToDeltedFromLocal = $this->db->query($queryTodeleteFromLocal);
		return $resultToDeltedFromLocal;
	}
	
}

?>