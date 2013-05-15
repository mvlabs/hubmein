<?php

namespace Events\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Events\Entity\Event;
use Events\Entity\Country;

class ZendDbEventMapper implements EventMapperInterface {

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
     * Get Event
     *
     * @param int Event Id
     * @throws DomainException
     * @return Event 
     */
    public function getEvent($i_id)
    {
        $rowset = $this->eventTable->select(array('id' => (int) $i_id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \DomainException("Could not find row $i_id");
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
    public function getCountry($i_id)
    {
        $rowset = $this->countryTable->select(array('id' => (int) $i_id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \DomainException("Could not find row $i_id");
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
    public function getEventList($i_country = null, $i_limit = null)
    {
        if (null === $i_country) {
            return $this->eventTable->select();
        }
        return $this->eventTable->select(array('country_id' => (int) $i_country));
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
     * @param Event Event to save
     */
    public function saveEvent(Event $I_event)
    {
        $data = $I_event->getArrayCopy();
        
        $id   = (int) $data['id'];
        if ($id === 0) {
            unset($data['id']);        // to let postgres generate it using sequences
            $this->eventTable->insert($data);
        } else {
            if ($this->getEvent($id)) {
                $this->eventTable->update($data, array('id' => $id));
            } else {
                throw new \DomainException("The event $id does not exist");
            }
        }
    }
}
