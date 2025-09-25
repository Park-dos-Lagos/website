<?php
/**
 * @package     VikBooking
 * @subpackage  com_vikbooking
 * @author      Alessio Gaggii - e4j - Extensionsforjoomla.com
 * @copyright   Copyright (C) 2018 e4j - Extensionsforjoomla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @link        https://vikwp.com
 */

defined('ABSPATH') or die('No script kiddies please!');

/**
 * Handles all the events involving a reservation.
 */
class VboBookingHistory
{
	/**
	 * @var  ?int
	 */
	protected $bid = null;

	/**
	 * @var  ?array
	 */
	protected $prevBooking = null;

	/**
	 * @var  mixed
	 */
	protected $data = null;

	/**
	 * @var  array
	 */
	protected $typesMap = [];

	/**
	 * @var  array
	 * 
	 * @since  	1.18.0 (J) - 1.8.0 (WP)
	 */
	protected $bookingInfo = [];

	/**
	 * @var  array
	 * 
	 * @since  	1.18.0 (J) - 1.8.0 (WP)
	 */
	protected $bookingRooms = [];

	/**
	 * @var  array 	Static cache to identify duplicate operations.
	 * 
	 * @since  	1.18.0 (J) - 1.8.0 (WP)
	 */
	protected static $signaturesList = [];

	/**
	 * List of event types worthy of a notification.
	 * 
	 * @var  	array
	 * 
	 * @since 	1.15.0 (J) - 1.5.0 (WP)
	 */
	protected $worthy_events = [
		'NC',
		'MW',
		'NP',
		'P0',
		'PN',
		'CR',
		'CW',
		'MC',
		'CC',
		'NO',
		'PO',
		'IR',
		'PC',
		'UR',
	];

	/**
	 * List of event types supported by the Notifications Center.
	 * 
	 * @var 	array
	 * 
	 * @since 	1.16.8 (J) - 1.6.8 (WP)
	 */
	protected $notificationsCenterTypes = [
		// New booking with status Confirmed
		'NC',
		// Booking paid for the first time
		'P0',
		// Booking paid for a second time
		'PN',
		// Booking modified from website
		'MW',
		// Cancellation request message
		'CR',
		// Booking cancelled via front-end website
		'CW',
		// Booking modified from channel
		'MC',
		// Booking cancelled from channel
		'CC',
		// New Booking from OTA
		'NO',
		// Overbooking
		'OB',
		// Channel Manager payout notification
		'PO',
		// Pre-checkin updated via front-end
		'PC',
		// Guest review received
		'GR',
	];

	/**
	 * List of Task Manager events for a new booking.
	 * 
	 * @var 	array
	 * 
	 * @since 	1.18.0 (J) - 1.8.0 (WP)
	 */
	protected $taskManagerEventsNewBooking = [
		// New booking with status Confirmed
		'NC',
		// New booking from back-end
		'NB',
		// Booking paid for the first time
		'P0',
		// Booking set to Confirmed by admin
		'TC',
		// Booking set to Confirmed via App
		'AC',
		// New booking via App
		'AN',
		// New Booking from OTA
		'NO',
	];

	/**
	 * List of Task Manager events for a modified booking.
	 * 
	 * @var 	array
	 * 
	 * @since 	1.18.0 (J) - 1.8.0 (WP)
	 */
	protected $taskManagerEventsModifiedBooking = [
		// Booking modified from website
		'MW',
		// Booking modified from back-end
		'MB',
		// Booking modified from channel
		'MC',
		// Booking modified via App
		'AM',
	];

	/**
	 * List of Task Manager events for a cancelled booking.
	 * 
	 * @var 	array
	 * 
	 * @since 	1.18.0 (J) - 1.8.0 (WP)
	 */
	protected $taskManagerEventsCancelledBooking = [
		// Booking cancelled via front-end website
		'CW',
		// Booking cancelled via back-end by admin
		'CB',
		// Booking cancelled from channel
		'CC',
		// Booking removed via App
		'AR',
	];

	/**
	 * Class constructor.
	 * 
	 * @param 	int 	$bid 	optional booking ID to set.
	 * 
	 * @since 	1.16.5 (J) - 1.6.5 (WP) added argument $bid.
	 */
	public function __construct($bid = 0)
	{
		$this->typesMap = $this->getTypesMap();

		if ($bid) {
			$this->bid = (int) $bid;
		}
	}

	/**
	 * Returns an array of types mapped to
	 * the corresponding language definition.
	 * All the history types should be listed here.
	 *
	 * @return 	array
	 */
	public function getTypesMap()
	{
		return [
			// New booking with status Confirmed
			'NC' => JText::_('VBOBOOKHISTORYTNC'),
			// Booking modified from website
			'MW' => JText::_('VBOBOOKHISTORYTMW'),
			// Booking modified from back-end
			'MB' => JText::_('VBOBOOKHISTORYTMB'),
			// New booking from back-end
			'NB' => JText::_('VBOBOOKHISTORYTNB'),
			// New booking with status Pending
			'NP' => JText::_('VBOBOOKHISTORYTNP'),
			// Booking paid for the first time
			'P0' => JText::_('VBOBOOKHISTORYTP0'),
			// Booking paid for a second time
			'PN' => JText::_('VBOBOOKHISTORYTPN'),
			// Cancellation request message
			'CR' => JText::_('VBOBOOKHISTORYTCR'),
			// Booking cancelled via front-end website
			'CW' => JText::_('VBOBOOKHISTORYTCW'),
			// Booking auto cancelled via front-end
			'CA' => JText::_('VBOBOOKHISTORYTCA'),
			// Booking cancelled via back-end by admin
			'CB' => JText::_('VBOBOOKHISTORYTCB'),
			// Booking Receipt generated via back-end
			'BR' => JText::_('VBOBOOKHISTORYTBR'),
			// Booking Invoice generated
			'BI' => JText::_('VBOBOOKHISTORYTBI'),
			// Booking registration unset status by admin
			'RA' => JText::_('VBOBOOKHISTORYTRA'),
			// Booking checked-in status set by admin
			'RB' => JText::_('VBOBOOKHISTORYTRB'),
			// Booking checked-out status set by admin
			'RC' => JText::_('VBOBOOKHISTORYTRC'),
			// Booking no-show status set by admin
			'RZ' => JText::_('VBOBOOKHISTORYTRZ'),
			// Booking set to Confirmed by admin
			'TC' => JText::_('VBOBOOKHISTORYTTC'),
			// Booking set to Confirmed via App
			'AC' => JText::_('VBOBOOKHISTORYTAC'),
			// Booking modified from channel
			'MC' => JText::_('VBOBOOKHISTORYTMC'),
			// Booking cancelled from channel
			'CC' => JText::_('VBOBOOKHISTORYTCC'),
			// Booking removed via App
			'AR' => JText::_('VBOBOOKHISTORYTAR'),
			// Booking modified via App
			'AM' => JText::_('VBOBOOKHISTORYTAM'),
			// New booking via App
			'AN' => JText::_('VBOBOOKHISTORYTAN'),
			// New Booking from OTA
			'NO' => JText::_('VBOBOOKHISTORYTNO'),
			// Report affecting the booking
			'RP' => JText::_('VBOBOOKHISTORYTRP'),
			// Custom email sent to the customer by admin
			'CE' => JText::_('VBOBOOKHISTORYTCE'),
			// Custom SMS sent to the customer by admin
			'CS' => JText::_('VBOBOOKHISTORYTCS'),
			// Confirmation email re-sent by admin to guest
			'ER' => JText::_('VBRESENDORDEMAIL'),
			// Payment Update (a new amount paid has been set)
			'PU' => JText::_('VBOBOOKHISTORYTPU'),
			// Upsell Extras via front-end
			'UE' => JText::_('VBOBOOKHISTORYTUE'),
			// Report guest misconduct to OTA
			'GM' => JText::_('VBOBOOKHISTORYTGM'),
			// Send Email Cancellation by admin
			'EC' => JText::_('VBOBOOKHISTORYTEC'),
			// Amount refunded
			'RF' => JText::_('VBOBOOKHISTORYTRF'),
			// Refund Updated
			'RU' => JText::_('VBOBOOKHISTORYTRU'),
			// Payable Amount Updated
			'PB' => JText::_('VBOBOOKHISTORYTPB'),
			// Channel Manager custom event
			'CM' => JText::_('VBOBOOKHISTORYTCM'),
			// Channel Manager payout notification
			'PO' => JText::_('VBOBOOKHISTORYTPO'),
			// Inquiry reservation (website)
			'IR' => JText::_('VBOBOOKHISTORYTIR'),
			// Pre-checkin updated via front-end
			'PC' => JText::_('VBOBOOKHISTORYTPC'),
			// Guest review received
			'GR' => JText::_('VBOBOOKHISTORYTGR'),
			// Upgrade room
			'UR' => JText::_('VBOBOOKHISTORYTUR'),
			// Overbooking
			'OB' => JText::_('VBOBOOKHISTORYTOB'),
			// Task Manager - General event (i.e. task status updated)
			'TM' => JText::_('VBOBOOKHISTORYTTM'),
			// Task Manager - New tasks
			'NT' => JText::_('VBOBOOKHISTORYTNT'),
			// Task Manager - Modified tasks
			'MT' => JText::_('VBOBOOKHISTORYTMT'),
			// Task Manager - Cancelled tasks
			'CT' => JText::_('VBOBOOKHISTORYTCT'),
		];
	}

	/**
	 * Accesses the groups of history event types, useful to group multiple events.
	 * Groups are categories of events containing worthy event types of the same context.
	 * 
	 * @param 	string 	$group 	get the list of event types of this group.
	 * 
	 * @return 	array 			associative array of types group or empty array.
	 * 
	 * @since 	1.16.0 (J) - 1.6.0 (WP)
	 */
	public function getTypeGroups($group = null)
	{
		// we group various types of events per category
		$type_groups = [
			// group "Bookings"
			'GBK' => [
				'name' 	=> JText::_('VBMENUTHREE'),
				'types' => [
					'NC',
					'MW',
					'NP',
					'CR',
					'CW',
					'MC',
					'CC',
					'NO',
					'IR',
					'UR',
					'OB',
				],
			],
			// group "Channel Manager"
			'GCM' => [
				'name' 	=> JText::_('VBMENUCHANNELMANAGER'),
				'types' => [
					'MC',
					'CC',
					'NO',
					'PO',
					'CM',
					'OB',
				],
			],
			// group "Website"
			'GWB' => [
				'name' 	=> JText::_('VBORDFROMSITE'),
				'types' => [
					'NC',
					'MW',
					'NP',
					'CR',
					'CW',
					'IR',
					'PC',
					'UE',
					'GR',
					'UR',
				],
			],
			// group "Payments"
			'GPM' => [
				'name' 	=> JText::_('VBO_HISTORY_GPM'),
				'types' => [
					'P0',
					'PN',
					'PO',
					'RF',
				],
			],
		];

		if ($group) {
			// attempt to fetch the requested group
			return $type_groups[$group] ?? [];
		}

		// return the whole associative list
		return $type_groups;
	}

	/**
	 * Checks whether the type for the history record is valid.
	 *
	 * @param 	string 		$type
	 * @param 	bool 		$returnit 	True for returning the translated value. Bool is returned otherwise.
	 *
	 * @return 	bool
	 */
	public function validType($type, $returnit = false)
	{
		if ($returnit) {
			return isset($this->typesMap[strtoupper($type)]) ? $this->typesMap[strtoupper($type)] : $type;
		}

		return isset($this->typesMap[strtoupper($type)]);
	}

	/**
	 * Sets the current booking ID.
	 * 
	 * @param 	int 	$bid
	 *
	 * @return 	VboBookingHistory
	 **/
	public function setBid($bid)
	{
		$this->bid = (int) $bid;

		return $this;
	}

	/**
	 * Sets the previous booking array.
	 * To calculate what has changed in the booking after the
	 * modification, VBO uses the method getLogBookingModification().
	 * VCM instead should use this method to tell the class that
	 * what has changed should be calculated to obtain the 'descr'
	 * text of the history record that will be stored.
	 * 
	 * @param 	array 	$booking
	 *
	 * @return 	VboBookingHistory
	 **/
	public function setPrevBooking($booking)
	{
		if (is_array($booking)) {
			$this->prevBooking = $booking;
		}

		return $this;
	}

	/**
	 * Sets extra data for the current history log.
	 * 
	 * @param 	mixed 	$data 	array, object or string of extra data.
	 * 							Useful to store the amount paid to be invoiced,
	 * 							or the transaction details of the payments.
	 *
	 * @return 	VboBookingHistory
	 **/
	public function setExtraData($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Sets the current booking room records.
	 * 
	 * @param 	array 	$booking_rooms 	The current booking room records.
	 *
	 * @return 	VboBookingHistory
	 * 
	 * @since 	1.18.0 (J) - 1.8.0 (WP)
	 */
	public function setBookingRooms(array $booking_rooms)
	{
		$this->bookingRooms = $booking_rooms;
	}

	/**
	 * Sets the current booking record.
	 * 
	 * @param 	array 	$booking 	The current booking record.
	 *
	 * @return 	VboBookingHistory
	 * 
	 * @since 	1.18.0 (J) - 1.8.0 (WP)
	 */
	public function setBookingInfo(array $booking)
	{
		$this->bookingInfo = $booking;

		if (is_array(($booking['rooms_info'] ?? null)) && $booking['rooms_info']) {
			// booking room records may be available within the booking record itself
			$this->setBookingRooms($booking['rooms_info']);
		}
	}

	/**
	 * Sets the current booking data.
	 * 
	 * @param 	array 	$booking 		The current booking record.
	 * @param 	array 	$booking_rooms 	The current booking room records.
	 *
	 * @return 	VboBookingHistory
	 * 
	 * @since 	1.18.0 (J) - 1.8.0 (WP)
	 */
	public function setBookingData(array $booking, array $booking_rooms = [])
	{
		$this->setBookingInfo($booking);

		if ($booking_rooms) {
			$this->setBookingRooms($booking_rooms);
		}

		return $this;
	}

	/**
	 * Fetches the current booking record.
	 *
	 * @return 	?array
	 */
	protected function getBookingInfo()
	{
		$dbo = JFactory::getDbo();

		if ($this->bookingInfo && ($this->bookingInfo['id'] ?? 0) == $this->bid) {
			// return the cached value
			return $this->bookingInfo;
		}

		$q = $dbo->getQuery(true)
			->select('*')
			->from($dbo->qn('#__vikbooking_orders'))
			->where($dbo->qn('id') . ' = ' . (int) $this->bid);

		$dbo->setQuery($q, 0, 1);
		$record = $dbo->loadAssoc();

		if (!$record) {
			return null;
		}

		// cache booking information internally
		$this->bookingInfo = $record;

		return $record;
	}

	/**
	 * Stores a new history record for the booking.
	 * 
	 * @param 	string 	$type 	Char-type of storing we are making for the history.
	 * @param 	string 	$descr 	Optional description of this booking record.
	 *
	 * @return 	bool
	 */
	public function store($type, $descr = '')
	{
		$dbo = JFactory::getDbo();

		if (is_null($this->bid) || !$this->validType($type)) {
			return false;
		}

		if (!$booking_info = $this->getBookingInfo()) {
			return false;
		}

		/**
		 * Define the current storing signature.
		 * 
		 * @since 	1.18.0 (J) - 1.8.0 (WP)
		 */
		$storingSignature = implode('-', [$type, $this->bid]);

		if (empty($descr) && $this->prevBooking) {
			/**
			 * VCM (including the App) could set the previous booking information,
			 * so we need to calculate what has changed with the booking.
			 * Load VBO language.
			 */
			$lang = JFactory::getLanguage();
			$lang->load('com_vikbooking', (VBOPlatformDetection::isWordPress() ? VIKBOOKING_ADMIN_LANG : JPATH_ADMINISTRATOR), $lang->getTag(), true);
			$descr = VikBooking::getLogBookingModification($this->prevBooking);
		}

		// get the event dispatcher
		$dispatcher = VBOFactory::getPlatform()->getDispatcher();

		// build record object
		$history_record = new stdClass;
		$history_record->idorder = $this->bid;
		$history_record->dt 	 = JFactory::getDate()->toSql();
		$history_record->type 	 = $type;
		$history_record->descr 	 = $descr ?: null;
		$history_record->totpaid = (float) $booking_info['totpaid'];
		$history_record->total 	 = (float) $booking_info['total'];
		$history_record->data 	 = $this->data;

		/**
		 * Trigger event before saving a new history record.
		 * 
		 * @since 	1.16.0 (J) - 1.6.0 (WP)
		 */
		$results = $dispatcher->filter('onBeforeSaveBookingHistoryVikBooking', [$history_record, $this->prevBooking]);
		if (in_array(false, $results, true)) {
			return false;
		}

		/**
		 * Store the extra data for this history log. Useful to store
		 * information about the amount paid, its invoicing status or any custom data.
		 * 
		 * @since 	1.12 (J) - 1.1.7 (WP)
		 */
		if (!is_null($history_record->data) && !is_scalar($history_record->data)) {
			$history_record->data = json_encode($history_record->data);
		}

		// store record
		if (!$dbo->insertObject('#__vikbooking_orderhistory', $history_record, 'id') || !isset($history_record->id)) {
			return false;
		}

		/**
		 * Trigger event for the newly history record added.
		 * 
		 * @since 	1.16.0 (J) - 1.6.0 (WP)
		 */
		$dispatcher->trigger('onAfterSaveBookingHistoryVikBooking', [$history_record, $this->prevBooking]);

		/**
		 * Check if the event requires an entry to be stored in the Notifications Center.
		 * 
		 * @since 	1.16.8 (J) - 1.6.8 (WP)
		 */
		$results = $dispatcher->filter('onBeforeSaveHistoryNotificationsCenter', [$history_record, $this->notificationsCenterTypes]);
		if (in_array($type, $this->notificationsCenterTypes) || in_array(true, $results, true)) {
			$this->addToNotificationsCenter($history_record, $booking_info);
		}

		/**
		 * Check if the Task Manager framework should run for the current event type.
		 * 
		 * @since 	1.18.0 (J) - 1.8.0 (WP)
		 */
		if (!in_array($storingSignature, static::$signaturesList)) {
			// we can safely invoke the Task Manager framework for a unique event
			if (in_array($type, $this->taskManagerEventsNewBooking)) {
				// process the new booking confirmation tasks
				VBOFactory::getTaskManager()->processBookingConfirmation($this->bookingInfo, $this->bookingRooms);
			} elseif (in_array($type, $this->taskManagerEventsCancelledBooking)) {
				// process the booking cancellation tasks
				VBOFactory::getTaskManager()->processBookingCancellation($this->bookingInfo, $this->bookingRooms);
			} elseif (in_array($type, $this->taskManagerEventsModifiedBooking)) {
				// process the booking modification tasks
				VBOFactory::getTaskManager()->processBookingModification($this->bookingInfo, $this->bookingRooms, (array) $this->prevBooking);
			}
		}

		/**
		 * Populate a static cache list to prevent duplicate operations from being executed, unless required.
		 * 
		 * @since 	1.18.0 (J) - 1.8.0 (WP)
		 */
		static::$signaturesList[] = $storingSignature;

		// operation completed with success
		return true;
	}

	/**
	 * Loads the history records for the booking ID set.
	 * 
	 * @param 	int 	$offset 	query offset limit start.
	 * @param 	int 	$limit 		query maximum records to fetch.
	 *
	 * @return 	array
	 * 
	 * @since 	1.16.5 (J) - 1.6.5 (WP) added arguments $offset and $limit.
	 */
	public function loadHistory($offset = 0, $limit = 0)
	{
		$dbo = JFactory::getDbo();

		if (empty($this->bid)) {
			return [];
		}

		$q = $dbo->getQuery(true)
			->select('*')
			->from($dbo->qn('#__vikbooking_orderhistory'))
			->where($dbo->qn('idorder') . ' = ' . (int) $this->bid)
			->order($dbo->qn('dt') . ' DESC')
			->order($dbo->qn('id') . ' DESC');

		$dbo->setQuery($q, $offset, $limit);

		return $dbo->loadAssocList();
	}

	/**
	 * Checks whether this booking has an event of the given type.
	 * 
	 * @param 	string 	$type 	the type of the event.
	 *
	 * @return 	mixed 			last date on success, false otherwise.
	 * 
	 * @since 	1.13.5 (J) - 1.3.5 (WP)
	 */
	public function hasEvent($type)
	{
		$dbo = JFactory::getDbo();

		if (empty($type) || empty($this->bid)) {
			return false;
		}

		$q = $dbo->getQuery(true)
			->select($dbo->qn('dt'))
			->from($dbo->qn('#__vikbooking_orderhistory'))
			->where($dbo->qn('idorder') . ' = ' . (int) $this->bid)
			->where($dbo->qn('type') . ' = ' . $dbo->q($type))
			->order($dbo->qn('dt') . ' DESC');

		$dbo->setQuery($q, 0, 1);

		$dt = $dbo->loadResult();

		if (!$dt) {
			return false;
		}

		return $dt;
	}

	/**
	 * Returns a list of records with data defined for the given event type.
	 * Useful to get a list of transactions data for the refund operations.
	 * 
	 * @param 	mixed 		$type 		string or array event type(s).
	 * @param 	callable 	$callvalid 	callback for the data validation.
	 * @param 	bool 		$onlydata 	whether to get just the event data.
	 *
	 * @return 	mixed 					false or array with data records.
	 * 
	 * @since 	1.14.0 (J) - 1.4.0 (WP)
	 */
	public function getEventsWithData($type, $callvalid = null, $onlydata = true)
	{
		$dbo = JFactory::getDbo();

		if (empty($type) || empty($this->bid)) {
			return false;
		}

		if (!is_array($type)) {
			$type = [$type];
		}

		// quote all given types
		$types = array_map([$dbo, 'q'], $type);

		$q = $dbo->getQuery(true)
			->select('*')
			->from($dbo->qn('#__vikbooking_orderhistory'))
			->where($dbo->qn('idorder') . ' = ' . (int) $this->bid)
			->where($dbo->qn('type') . ' IN (' . implode(', ', $types) . ')')
			->order($dbo->qn('dt') . ' ASC');

		$dbo->setQuery($q);
		$events = $dbo->loadAssocList();

		if ($events) {
			$datas  = [];
			foreach ($events as $k => $e) {
				$data = json_decode($e['data']);
				if (!empty($data)) {
					$events[$k]['data'] = $data;
				}
				$valid_data = true;
				if (is_callable($callvalid)) {
					$valid_data = call_user_func($callvalid, $events[$k]['data']);
				}
				if ($valid_data) {
					array_push($datas, $events[$k]['data']);
				}
			}

			return $onlydata ? $datas : $events;
		}

		return false;
	}

	/**
	 * Gets the latest history event per booking within a list.
	 * Only the latest event per booking will be considered.
	 * 
	 * @param 	int 	$start 	 the query start offset.
	 * @param 	int 	$limit 	 the query limit.
	 * @param 	int 	$min_id  optional minimum history ID to fetch.
	 * @param 	array 	$types 	 optional list of event types (or groups) to fetch.
	 * 
	 * @return 	array 			 the list of recent history record objects.
	 * 
	 * @since 	1.15.0 (J) - 1.5.0 (WP)
	 * @since 	1.16.0 (J) - 1.6.0 (WP) query modified to fetch the customer picture.
	 * @since 	1.16.0 (J) - 1.6.0 (WP) fourth argument $types introduced.
	 */
	public function getLatestBookingEvents($start = 0, $limit = 20, $min_id = 0, array $types = [])
	{
		$dbo = JFactory::getDbo();

		$clauses = [];

		if ($min_id > 0) {
			$clauses[] = "`h`.`id` > " . (int)$min_id;
		} else {
			$clauses[] = "`h`.`id` > 0";
		}

		if ($types) {
			// scan for groups
			$groups = [];
			foreach ($types as $k => $type) {
				if ($type && strlen($type) === 3 && $group = $this->getTypeGroups($type)) {
					$groups = array_merge($groups, $group['types']);
					unset($types[$k]);
				}
			}

			if ($groups) {
				// merge all types
				$types = array_merge(array_values($types), array_unique($groups));
			}

			// quote all values
			$types = array_map(array($dbo, 'q'), array_filter($types));

			if ($types) {
				// add query clause
				$clauses[] = "`h`.`type` IN (" . implode(', ', $types) . ")";
			}
		}

		/**
		 * On some servers with just 30k records in the history and 5k in bookings,
		 * the INNER JOIN to group the latest history events by booking ID is taking
		 * ~25 seconds to complete, which is not acceptable. This doesn't seem to happen
		 * on every database, but since the admin widget "latest events" requires to get
		 * just the latest history event ID by passing the limit to 1, we should not
		 * use the INNER JOIN all the times to save server resources.
		 * Refactoring performed to abandon also the LEFT JOINS which were timing out in
		 * case of several thousands of records. The widget "latest_events" crashed websites.
		 * 
		 * @since 	1.15.6 (J) - 1.5.12 (WP)
		 * @since 	1.16.0 (J) - 1.6.0 (WP) INNER JOIN dismissed because too slow and not needed.
		 * @since 	1.16.1 (J) - 1.6.1 (WP) LEFT JOIN dismissed because too slow, queries split.
		 */

		// query just the history records without joining any other table, or the records would become hundreds of thousands
		$q = $dbo->getQuery(true)
			->select($dbo->qn('h') . '.*')
			->from($dbo->qn('#__vikbooking_orderhistory', 'h'))
			->where(implode(' AND ', $clauses))
			->order($dbo->qn('h.dt') . ' DESC')
			->order($dbo->qn('h.id') . ' DESC');

		$dbo->setQuery($q, $start, $limit);
		$rows = $dbo->loadObjectList();
		if (!$rows) {
			return [];
		}

		// build a list of reservation IDs
		$history_orders = [];
		foreach ($rows as $row) {
			$history_orders[] = (int)$row->idorder;
		}
		$history_orders = array_unique($history_orders);

		// fetch the rest of the information
		$q = "SELECT `o`.`id` AS `idorder`, `o`.`custdata`, `o`.`status`, `o`.`days`, `o`.`checkin`, `o`.`checkout`, `o`.`totpaid`,
			`o`.`total`, `o`.`idorderota`, `o`.`channel`, `o`.`country`, `o`.`closure`, `o`.`type` AS `booking_type`, `c`.`pic`,
			(
				SELECT CONCAT_WS(' ',`or`.`t_first_name`,`or`.`t_last_name`) 
				FROM `#__vikbooking_ordersrooms` AS `or` 
				WHERE `or`.`idorder`=`o`.`id` LIMIT 1
			) AS `nominative`
			FROM `#__vikbooking_orders` AS `o`
			LEFT JOIN `#__vikbooking_customers_orders` AS `co` ON `co`.`idorder`=`o`.`id`
			LEFT JOIN `#__vikbooking_customers` AS `c` ON `c`.`id`=`co`.`idcustomer`
			WHERE `o`.`id` IN (" . implode(', ', $history_orders) . ");";

		$dbo->setQuery($q);
		$rows_data = $dbo->loadObjectList();
		if (!$rows_data) {
			return [];
		}

		// merge information to object records
		foreach ($rows as &$row) {
			foreach ($rows_data as $row_data) {
				if ($row_data->idorder != $row->idorder) {
					continue;
				}

				// merge object properties by using casting
				$row = (object) array_merge((array) $row, (array) $row_data);

				break;
			}
		}

		// unset last reference
		unset($row);

		// return the final list
		return $rows;
	}

	/**
	 * Helper method to set a new list of worthy event types.
	 * 
	 * @param 	array 	$worthy_events  list of event type identifiers.
	 * 
	 * @return 	VboBookingHistory
	 * 
	 * @since 	1.15.0 (J) - 1.5.0 (WP)
	 */
	public function setWorthyEventTypes($worthy_events = [])
	{
		if (is_array($worthy_events)) {
			$this->worthy_events = $worthy_events;
		}

		return $this;
	}

	/**
	 * Helper method to get the list of worthy event types.
	 * 
	 * @return 	array
	 * 
	 * @since 	1.15.4 (J) - 1.5.10 (WP)
	 */
	public function getWorthyEventTypes()
	{
		return $this->worthy_events;
	}

	/**
	 * Gets the latest history events worthy of a notification.
	 * 
	 * @param 	int 	$min_id  optional minimum history ID to fetch.
	 * @param 	int 	$limit 	 the query limit.
	 * 
	 * @return 	array 			 the list of worthy history record objects.
	 * 
	 * @since 	1.15.0 (J) - 1.5.0 (WP)
	 * @since 	1.16.0 (J) - 1.6.0 (WP) query modified to fetch the customer picture.
	 * 									INNER JOIN dismissed.
	 */
	public function getWorthyEvents($min_id = 0, $limit = 0)
	{
		$dbo = JFactory::getDbo();

		$clauses = [
			"`o`.`status` IS NOT NULL",
			"`o`.`closure` = 0"
		];

		if ($min_id > 0) {
			$clauses[] = "`h`.`id` > " . (int)$min_id;
		}

		if ($this->worthy_events) {
			// quote all worthy types of event
			$worthy_types = array_map(array($dbo, 'q'), $this->worthy_events);
			$clauses[] = "`h`.`type` IN (" . implode(', ', $worthy_types) . ")";
		}

		// join as few tables as possible to reduce the execution timing
		$q = $dbo->getQuery(true)
			->select($dbo->qn('h') . '.*')
			->select([
				$dbo->qn('o.status'),
				$dbo->qn('o.days'),
				$dbo->qn('o.checkin'),
				$dbo->qn('o.checkout'),
				$dbo->qn('o.totpaid'),
				$dbo->qn('o.total'),
				$dbo->qn('o.idorderota'),
				$dbo->qn('o.channel'),
				$dbo->qn('o.country'),
			])
			->from($dbo->qn('#__vikbooking_orderhistory', 'h'))
			->leftJoin($dbo->qn('#__vikbooking_orders', 'o') . ' ON ' . $dbo->qn('h.idorder') . ' = ' . $dbo->qn('o.id'))
			->where(implode(' AND ', $clauses))
			->order($dbo->qn('h.dt') . ' DESC')
			->order($dbo->qn('h.id') . ' DESC');

		$dbo->setQuery($q, 0, $limit);
		$rows = $dbo->loadObjectList();

		if (!$rows) {
			return [];
		}

		// set the "pic" property to a default empty value
		foreach ($rows as &$row) {
			$row->pic = '';
		}

		// unset last reference
		unset($row);

		// build a list of reservation IDs
		$history_orders = [];
		foreach ($rows as $row) {
			$history_orders[] = (int)$row->idorder;
		}
		$history_orders = array_unique($history_orders);

		// fetch the rest of the information
		$q = $dbo->getQuery(true)
			->select([
				$dbo->qn('o.id'),
				$dbo->qn('c.pic'),
			])
			->from($dbo->qn('#__vikbooking_orders', 'o'))
			->leftJoin($dbo->qn('#__vikbooking_customers_orders', 'co') . ' ON ' . $dbo->qn('co.idorder') . ' = ' . $dbo->qn('o.id'))
			->leftJoin($dbo->qn('#__vikbooking_customers', 'c') . ' ON ' . $dbo->qn('c.id') . ' = ' . $dbo->qn('co.idcustomer'))
			->where($dbo->qn('o.id') . ' IN (' . implode(', ', $history_orders) . ')');

		$dbo->setQuery($q);
		$rows_data = $dbo->loadObjectList();

		if ($rows_data) {
			// merge information
			foreach ($rows as &$row) {
				foreach ($rows_data as $row_data) {
					if ($row_data->id != $row->idorder) {
						continue;
					}

					// set picture property
					$row->pic = $row_data->pic;
					break;
				}
			}
		}

		// return all records found
		return $rows;
	}

	/**
	 * Builds a summary of what was changed with a booking modification event.
	 * 
	 * @param 	array 	$booking_info 		the booking information record.
	 * 
	 * @return 	string
	 * 
	 * @since 	1.16.8 (J) - 1.6.8 (WP)
	 */
	public function getBookingModificationSummary(array $booking_info)
	{
		if (!$this->prevBooking) {
			return '';
		}

		$data_changed = [];

		// check the stay dates
		if (date('Y-m-d', $booking_info['checkin']) != date('Y-m-d', $this->prevBooking['checkin'])) {
			$data_changed[] = 'checkin';
		}
		if (date('Y-m-d', $booking_info['checkout']) != date('Y-m-d', $this->prevBooking['checkout'])) {
			$data_changed[] = 'checkout';
		}
		if ($booking_info['days'] != $this->prevBooking['days']) {
			$data_changed[] = 'days';
		}

		// check rooms and guests
		if (!empty($this->prevBooking['rooms_info'])) {
			// build previous values
			$prev_room_ids = array_column($this->prevBooking['rooms_info'], 'idroom');
			$prev_adults   = array_column($this->prevBooking['rooms_info'], 'adults');
			$prev_children = array_column($this->prevBooking['rooms_info'], 'children');

			// build new values
			$new_rooms_info = VikBooking::loadOrdersRoomsData($booking_info['id']);
			if ($new_rooms_info && $prev_room_ids) {
				$now_room_ids = array_column($new_rooms_info, 'idroom');
				$now_adults   = array_column($new_rooms_info, 'adults');
				$now_children = array_column($new_rooms_info, 'children');

				// normalize arrays
				$prev_room_ids = array_map('intval', $prev_room_ids);
				$now_room_ids  = array_map('intval', $now_room_ids);
				sort($prev_room_ids);
				sort($now_room_ids);

				// check if anything has changed
				if ($prev_room_ids != $now_room_ids) {
					$data_changed[] = 'rooms';
				}
				if (array_sum($prev_adults) != array_sum($now_adults) || array_sum($prev_children) != array_sum($now_children)) {
					$data_changed[] = 'guests';
				}
			}
		}

		// check totals
		if ($booking_info['total'] != $this->prevBooking['total']) {
			$data_changed[] = 'total';
		}

		if (!$data_changed) {
			// no changes detected
			return '';
		}

		// obtain the translations for what has changed
		$factors_changed = array_map(function($changed) {
			switch ($changed) {
				case 'checkin':
					return JText::_('VBPICKUPAT');

				case 'checkout':
					return JText::_('VBRELEASEAT');

				case 'days':
					return JText::_('VBOINVTOTNIGHTS');

				case 'rooms':
					return JText::_('VBPVIEWORDERSTHREE');

				case 'guests':
					return JText::_('VBPVIEWORDERSPEOPLE');

				case 'total':
					return JText::_('VBPVIEWORDERSSEVEN');
				
				default:
					return $changed;
			}
		}, $data_changed);

		if (count($factors_changed) > 1) {
			// plural version
			return JText::sprintf('VBO_BOOK_MOD_SUMMARY_PLR', implode(', ', $factors_changed));
		}

		// singular version
		return JText::sprintf('VBO_BOOK_MOD_SUMMARY_SNG', implode(', ', $factors_changed));
	}

	/**
	 * Adds the history event to the Notifications Center.
	 * 
	 * @param 	object 	$history_record 	the history record created.
	 * @param 	array 	$booking_info 		the booking information record.
	 * 
	 * @return 	bool
	 * 
	 * @since 	1.16.8 (J) - 1.6.8 (WP)
	 */
	protected function addToNotificationsCenter($history_record, array $booking_info)
	{
		if (VikBooking::isSite()) {
			// load language according to platform
			$lang = JFactory::getLanguage();
			if (VBOPlatformDetection::isJoomla()) {
				// make sure to load the back-end language definitions and any override
				$lang->load('com_vikbooking', JPATH_ADMINISTRATOR, $lang->getTag(), true);
				$lang->load('joomla', JPATH_ADMINISTRATOR, $lang->getTag(), true);
			} else {
				$lang->load('com_vikbooking', VIKBOOKING_LANG, $lang->getTag(), true);

				// make sure to register the language handler
				$lib_base_path = defined('VIKBOOKING_LIBRARIES') ? VIKBOOKING_LIBRARIES : '';
				if (!$lib_base_path && defined('VIKCHANNELMANAGER_LIBRARIES')) {
					$lib_base_path = str_replace('vikchannelmanager' . DIRECTORY_SEPARATOR . 'libraries', 'vikbooking' . DIRECTORY_SEPARATOR . 'libraries', VIKCHANNELMANAGER_LIBRARIES);
				}

				if ($lib_base_path) {
					$lang->attachHandler($lib_base_path . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . 'admin.php', 'vikbooking');
				}
			}

			// reload history types
			$this->typesMap = $this->getTypesMap();
		}

		// notification payload extra options
		$notif_payload_opts = [];

		// determine the notification sender
		$sender  = 'website';
		$channel = null;
		if (!empty($booking_info['channel']) && !empty($booking_info['idorderota'])) {
			// set proper notification group
			$sender  = 'otas';
			$channel = $booking_info['channel'];

			/**
			 * Set proper notification group and payload in case of a new OTA guest review.
			 * 
			 * @since 	1.16.10 (J) - 1.6.10 (WP)
			 */
			if (!strcasecmp($history_record->type, 'GR')) {
				$sender = 'guests';
				$ev_edata = (array) $this->data;
				if (($ev_edata['review_id'] ?? null) || ($ev_edata['ota_review_id'] ?? null)) {
					// build CTA payload for the notification
					$notif_payload_opts = [
						'summary'        => JText::sprintf('VBO_NEW_GUEST_REVIEW_SUMM', ($ev_edata['guest_name'] ?? ''), ($ev_edata['score'] ?? '?') . '/10'),
						'label'          => JText::_('VBO_NEW_GUEST_REVIEW'),
						'widget'         => 'guest_reviews',
						'widget_options' => [
							'review_id' => $ev_edata['review_id'] ?? 0,
							'ota_review_id' => $ev_edata['ota_review_id'] ?? '',
						],
					];
				}
			}
		}

		// build the notification summary
		$summary = $history_record->descr ?? null;
		if ($this->prevBooking) {
			// in case of booking modification, we compose a summary of just what was changed
			$summary = $this->getBookingModificationSummary($booking_info);
			$summary = $summary ?: null;
		}

		// store the notification
		try {
			$result = VBOFactory::getNotificationCenter()
				->store([
					array_merge([
						'sender'     => $sender,
						'type'       => $history_record->type,
						'title'      => $this->validType($history_record->type, true),
						'summary'    => $history_record->descr ?? null,
						'idorder'    => $history_record->idorder,
						'idorderota' => $booking_info['idorderota'] ?: null,
						'channel'    => $channel,
					], $notif_payload_opts),
				]);
		} catch (Exception $e) {
			return false;
		}

		return !empty($result['new_notifications']);
	}
}
