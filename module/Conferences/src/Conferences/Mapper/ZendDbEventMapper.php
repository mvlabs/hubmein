<?php

namespace Conferences\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Conferences\Entity\Conference;
use Conferences\Entity\Country;

class ZendDbConferenceMapper implements ConferenceMapperInterface {

    /**
     * @var TableGateway
     */
    protected $eventTable;

    /**
     * @var TableGateway
     */
    protected $countryTable;

	/*
	 * Constructs service 
	 * 
	 */
	public function __construct(TableGateway $eventTable, TableGateway $countryTable) {
        $this->eventTable   = $eventTable;
        $this->countryTable = $countryTable;
    }

    /**
     * Get Conference
     *
     * @param int Conference Id
     * @throws DomainException
     * @return Conference 
     */
    public function getConference($id)
    {
        $rowset = $this->eventTable->select(array('id' => (int) $id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \DomainException("Could not find row $id");
        }
        return $row;
    }


    /**
     * Get a country
     *
     * @param int Country id
     * @throws \DomainExeption
     * @return Country
     */
    public function getCountry($id)
    {
        $rowset = $this->countryTable->select(array('id' => (int) $id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \DomainException("Could not find row $id");
        }
        return $row;
    }

    /**
     * Get list of events
     *
     * @param int $i_country
     * @param int $i_limit
     * @return array
     */
    public function getConferenceList($country = null, $limit = null)
    {
        if (null === $country) {
            return $this->eventTable->select();
        }
        return $this->eventTable->select(array('country_id' => (int) $country));
    }

    /**
     * Get list of countries
     *
     * @return array
     */
    public function getCountryList()
    {
        $rowset = $this->countryTable->select();
        $result = array();
        foreach ($rowset as $row) {
            $result[$row->getId()] = $row->getName();
        }
        return $result;
    }

    /**
     * Save an event
     *
     * @param Conference Conference to save
     */
    public function saveConference(Conference $event)
    {
        $data = $event->getArrayCopy();
        
        $id   = (int) $data['id'];
        if ($id === 0) {
            unset($data['id']);        // to let postgres generate it using sequences
            $this->eventTable->insert($data);
        } else {
            if ($this->getConference($id)) {
                $this->eventTable->update($data, array('id' => $id));
            } else {
                throw new \DomainException("The event $id does not exist");
            }
        }
    }

    public function countListByFilter(\Conferences\DataFilter\RequestBuilder $requestBuilder) {
        
    }

    public function getListByFilter(\Conferences\DataFilter\RequestBuilder $requestBuilder) {
        
    }
}
