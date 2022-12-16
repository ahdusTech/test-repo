<?php

namespace App\Helper;

use Exception;
use Metaregistrar\EPP\eppConnection;
use Metaregistrar\EPP\eppException;
use Metaregistrar\EPP\eppInfoDomainRequest;
use Metaregistrar\EPP\eppDomain;
use Metaregistrar\EPP\eppUpdateDomainRequest;
use Metaregistrar\EPP\eppPollRequest;
use Metaregistrar\EPP\eppResponse;
use Metaregistrar\EPP\eppUndeleteRequest;
use Metaregistrar\EPP\eppRgpRestoreRequest;
use Metaregistrar\EPP\eppRgpRestoreResponse;
use Metaregistrar\EPP\eppDeleteDomainRequest;
use Metaregistrar\EPP\eppHost;
use Metaregistrar\EPP\eppContactHandle;
use Metaregistrar\EPP\eppCreateDomainRequest;
use Metaregistrar\EPP\eppTransferRequest;

class epp
{

    public function __construct()
    {
        $eppConnection = $this->eppConnection();

        try {
            $eppConnection->login();
        }catch (Exception $e){
            return $e->getMessage();
        }
        /*if (!$eppConnection->login())
            return array();*/
        $this->connection = $eppConnection;
    }

    private function eppConnection()
    {
        $conn = new eppConnection();
        $conn->setHostname('tls://epp.nic.ch'); // Hostname may vary depending on the registry selected
        $conn->setPort(700); // Port may vary depending on the registry selected
        $conn->setUsername('JRbYInOFIG21kE1v');
        $conn->setPassword('Vgz7UJm;LP');
        $conn->useExtension('rgp-1.0');
        return $conn;
    }

    public function lowerCaseAndDigits($length = 10)
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
        return $this->random_string($length, $characters);
    }
    public function randomDigits($length = 6)
    {
        $characters = "123456789";
        return $this->random_string($length, $characters);
    }

    private function random_string($length, $characters)
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function modifyDomain($domain, $handle, $tech, $dns1, $dns2)
    {
        try{
            $result = $this->epp_modify_domain($domain, $handle, $tech, $dns1, $dns2);
            $this->connection->logout();
            return $result;
        }catch (eppException | Exception $e){
            return $e->getMessage();
        }

    }

    private function epp_modify_domain($domain, $handle, $tech, $dns1, $dns2)
    {
        try {
            $del = null;
            $domainname = $domain;
            $domain = new eppDomain($domain);
            $info = new eppInfoDomainRequest($domain);
            if ($response = $this->connection->request($info)) {
                $oldns = $response->getDomainNameservers();
                if (is_array($oldns)) {
                    if (!$del) {
                        $del = new eppDomain($domainname);
                    }
                    foreach ($oldns as $ns) {
                        $del->addHost(new eppHost($ns->getHostname()));
                    }
                }

                $oldtech = $response->getDomainContact(eppContactHandle::CONTACT_TYPE_TECH);
                if (!$del) {
                    $del = new eppDomain($domainname);
                }
                $del->addContact(new eppContactHandle($oldtech, eppContactHandle::CONTACT_TYPE_TECH));
            }

            $mod = null;
            if ($handle) {
                $mod = new eppDomain($domainname);
                $mod->setRegistrant(new eppContactHandle($handle));
            }

            $add = null;
            if (!$add) {
                $add = new eppDomain($domainname);
            }
            $add->addContact(new eppContactHandle($tech, eppContactHandle::CONTACT_TYPE_TECH));
            $add->addHost(new eppHost($dns1));
            $add->addHost(new eppHost($dns2));

            $update = new eppUpdateDomainRequest($domain, $add, $del, $mod);
            $response = $this->connection->request($update);
            return true;
        } catch (eppException $e) {
            return $e->getMessage();
//            if ($response instanceof eppUpdateDomainResponse) {
//                echo $response->textContent . "\n";
//            }
//            die;
        }
    }

    public function transfer($domain, $auth_code, $handle, $tech, $dns1, $dns2)
    {
        try{
            $result = $this->epp_transfer($domain, $auth_code, $handle, $tech, $dns1, $dns2);
            $this->connection->logout();
            return $result;
        }catch (eppException | Exception $e){
            return $e->getMessage();
        }

    }

    private function epp_transfer($domain, $auth_code, $handle, $tech, $dns1, $dns2)
    {
        try{
            $d = new eppDomain($domain, $handle);
            $d->setAuthorisationCode($auth_code);
            $d->setRegistrant(new eppContactHandle($handle));
            $d->addContact(new eppContactHandle($tech, eppContactHandle::CONTACT_TYPE_TECH));
            $d->addHost(new eppHost($dns1));
            $d->addHost(new eppHost($dns2));
            $transfer = new eppTransferRequest(eppTransferRequest::OPERATION_REQUEST, $d);
            $response = $this->connection->request($transfer);
            if (!$response)
                return NULL;
            $result = [
                'name' => $response->getDomainName(),
            ];
            return $result;
        }catch (eppException | Exception $e){
            return $e->getMessage();
        }
    }

    public function register($domain, $handle, $tech, $dns1, $dns2)
    {


        try{
            $result = $this->epp_register($domain, $handle, $tech, $dns1, $dns2);
            $this->connection->logout();
            return $result;
        }catch (eppException | Exception $e){
            return $e->getMessage();
        }
    }

    private function epp_register($domain, $handle, $tech, $dns1, $dns2)
    {
        try {
            $d = new eppDomain($domain, $handle);
            $d->setRegistrant(new eppContactHandle($handle));
            $d->addContact(new eppContactHandle($tech, eppContactHandle::CONTACT_TYPE_TECH));
            $d->addHost(new eppHost($dns1));
            $d->addHost(new eppHost($dns2));
            $code = $this->lowerCaseAndDigits(12);
            $d->setAuthorisationCode($code);
            $create = new eppCreateDomainRequest($d);
            $response = $this->connection->request($create);
            if (!$response)
                return NULL;
            $result = [
                'name' => $response->getDomainName(),
                'creation_date' => $response->getDomainCreateDate(),
                'expiration_date' => $response->getDomainExpirationDate(),
                'authinfo' => $code,
            ];
            return $result;
        } catch (eppException | Exception $e) {
            return $e->getMessage();
        }
    }

    public function set_authinfo($domain, $auth_code)
    {
       /* $result = $this->epp_set_authinfo($domain, $auth_code);
        $this->connection->logout();
        return $result;*/
        try {
            $result = $this->epp_set_authinfo($domain, $auth_code);
            $this->connection->logout();
            return $result;
        }catch (Exception $e){
            return false;
            return $e->getMessage();
        }
    }

    private function epp_set_authinfo($domain, $code)
    {
        try {
            $mod = new eppDomain($domain);
            $mod->setAuthorisationCode($code);
            $update = new eppUpdateDomainRequest(new eppDomain($domain), NULL, NULL, $mod);
            $response = $this->connection->request($update);
            if (!$response)
                return NULL;
            return true;
        } catch (eppException | Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_multi($names)
    {
        foreach ($names as $key => $name) {
            if (!$name)
                continue;
            $this->epp_delete($name);
        }
        $this->connection->logout();
    }

    private function epp_delete($domain)
    {
        try {
            $delete = new eppDeleteDomainRequest(new eppDomain($domain));
            $response = $this->connection->request($delete);
            if (!$response)
                return NULL;
        } catch (eppException | Exception $e) {
            return $e->getMessage();
        }
    }

    private function epp_undelete($domain)
    {
        try {
            $undelete = new eppRgpRestoreRequest(new eppDomain($domain));
            $response = $this->connection->writeandread($undelete);
            if (!$response)
                return NULL;
            return [
                'rc' => $response->getResultCode(),
                'statuses' => $response->getRestoreStatuses(),
            ];
        } catch (eppException | Exception $e) {
            return $e->getMessage();
        }
    }

    public function undelete_multi($names)
    {
        /*foreach ($names as $key => $name) {
            if (!$name)
                continue;
            $this->epp_undelete($name);
        }
        $this->connection->logout();*/
        try {
            foreach ($names as $key => $name) {
                if (!$name)
                    continue;
                $this->epp_undelete($name);
            }
            $this->connection->logout();
        } catch (eppException | Exception $e) {
            return $e->getMessage();
        }
    }

    public function ack_result($message_id)
    {
        /*$result = $this->epp_ack($message_id);
        $this->connection->logout();
        return $result;*/
        try {
            $result = $this->epp_ack($message_id);
            $this->connection->logout();
            return $result;
        }catch (Exception $e){
            return false;
            return $e->getMessage();
        }
    }

    private function epp_ack($message_id)
    {
        /*$poll = new eppPollRequest(eppPollRequest::POLL_ACK, $message_id);
            $this->connection->request($poll);*/
        try {
            $poll = new eppPollRequest(eppPollRequest::POLL_ACK, $message_id);
            $this->connection->request($poll);
        } catch (eppException | Exception $e) {
            return $e->getMessage();
        }
    }

    public function poll()
    {
        $conn = $this->connection();
        if (!$conn->login())
            return NULL;
        $result = $this->epp_poll($conn);
        $conn->logout();
        return $result;
    }

    public function poll_results()
    {
        /*$pollInfo = $this->epp_poll();
        $this->connection->logout();
        return $pollInfo;*/
        try {
            $pollInfo = $this->epp_poll();
            $this->connection->logout();
            return $pollInfo;
        }catch (Exception $e){
            return false;
        }
    }

    private function epp_poll()
    {
        try {
            $poll = new eppPollRequest(eppPollRequest::POLL_REQ, 0);
            $response = $this->connection->request($poll);
            if (!$response)
                return NULL;
            if ($response->getResultCode() == eppResponse::RESULT_MESSAGE_ACK) {
                return [
                    'count' => $response->getMessageCount(),
                    'date' => $response->getMessageDate(),
                    'message_id' => $response->getMessageId(),
                    'msg' => $response->getMessage() ?? $response->saveXML(),
                ];
            } else {
                return [
                    'count' => -1,
                    'date' => NULL,
                    'message_id' => NULL,
                    'msg' => $response->getResultMessage(),
                ];
            }
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function getDomainInfo($domain)
    {
        /*$domainInfo = $this->epp_info($domain);
        $this->connection->logout();
        return $domainInfo;*/

        try {
            $domainInfo = $this->epp_info($domain);
            $this->connection->logout();
            return $domainInfo;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function epp_info($domain)
    {
        try {
            $info = new eppInfoDomainRequest(new eppDomain($domain));
            $response = $this->connection->request($info);
            if (!$response)
                return NULL;
            $d = $response->getDomain();
            $contacts = [];
            foreach ($d->getContacts() as $contact) {
                array_push($contacts, [
                    'type' => $contact->getContactType(),
                    'handle' => $contact->getContactHandle(),
                ]);
            }
            $nameservers = [];
            foreach ($d->getHosts() as $nameserver) {
                array_push($nameservers, $nameserver->getHostname());
            }
            $result = [
                'registrant' => $d->getRegistrant(),
                'contacts' => $contacts,
                'nameservers' => $nameservers,
                'expiration_date' => $response->getDomainExpirationDate(),
                'statuses' => $response->getDomainStatuses(),
            ];
            return $result;
        } catch (eppException $exception) {
            return $exception->getMessage();
        }
    }

}
