<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used for general application messages.
	|
	 */

	/**
	 * Data tables
	 */
	'name'                          => 'Namn',
	'desc'                          => 'Beskrivning',
	'id'                            => 'Id',
	'created'                       => 'Skapad',
	'modified'                      => 'Ändrad',
	'updated'                       => 'Uppdaterad',
	'info'                          => 'Info',
	'image'                         => 'Bild',
	'schedule'                      => 'Schemalägg',
	'scheduled'                     => 'Schemalagd',
	'ip_address'                    => 'IP adress',
	'summary'                       => 'Sammanfattning',
	'text'                          => 'Text',
	//'schedule'                    => 'Planering',

	/**
	 * Commonly used words.
	 */
	'add'                           => 'Lägg till',
	'close'                         => 'Stäng',
	'save'                          => 'Spara',
	'yes'                           => 'Ja',
	'no'                            => 'Nej',
	'active'                        => 'Aktiv',

	/**
	 * Models
	 */
	'screen_group'                  => 'Område',
	'screen_groups'                 => 'Områden',
	'add_screen_group'              => 'Lägg till område',
	'show_screen_group'             => 'Visa område',
	'edit_screen_group'             => 'Redigera område',
	'show_screen'                   => 'Visa bild',
	'edit_screen'                   => 'Redigera bild',
	'add_screen'                    => 'Lägg till bild',
	'add_ticker'                    => 'Ticker text',
	'edit_client'                   => 'Redigera bildskärm',

	'client'                        => 'Bildskärm',
	'clients'                       => 'Bildskärmar',
	'screen'                        => 'Bild',
	'screens'                       => 'Bilder',
	'event'                         => 'Event',
	'events'                        => 'Events',
	'user'                          => 'Användare',
	'users'                         => 'Användare',
	'ticker'                        => 'Ticker',
	'tickers'                       => 'Tickers',
	'role'                          => 'Roll',
	'roles'                         => 'Roller',
	'settings'                      => 'Inställningar',
	'tag'                           => 'Tag',
	'tags'                          => 'Taggar',

	/**
	 * Time/Date
	 */

	'date'                          => 'Datum',
	'start'                         => 'Start',
	'end'                           => 'Slut',
	'day'                           => 'Dag',
	'week'                          => 'Vecka',

	'recurring'                     => 'Återkommande',

	'repeat'                        => 'Upprepa:',
	'repeat_every'                  => 'Upprepa varje:',
	'repeat_each'                   => 'Upprepa varje:',
	'starts'                        => 'Startar:',
	'ends'                          => 'Slutar:',
	'never'                         => 'Aldrig',
	'at'                            => 'På:',
	'the'                           => 'Den:',
	'days_before_event'             => 'Visa innan',

	'start_date'                    => 'Start datum',
	'end_date'                      => 'Slut datum',
	'start_time'                    => 'Start tid',
	'end_time'                      => 'Slut tid',

	'frequency'                     => 'Frekvens',
	'day_frequency'                 => 'Var n:te dag',
	'week_frequency'                => 'Var n:te vecka',
	'month_frequency'               => 'Var n:te månad',
	'year_frequency'                => 'Var n:te år',

	'daily'                         => 'Dagligen',
	'weekly'                        => 'Veckovis',
	'monthly'                       => 'Månadsvis',
	'yearly'                        => 'Årligen',

	'days'                          => 'Dag|Dagar',
	'weeks'                         => 'Vecka|Veckor',
	'months'                        => 'Månad|Månader',
	'years'                         => 'År',

	'each_month'                    => 'varje månad.',
	'weekdays'                      => 'Veckodagar',

	'monday'                        => 'Måndagen',
	'tuesday'                       => 'Tisdagen',
	'wednesday'                     => 'Onsdagen',
	'thursday'                      => 'Torsdagen',
	'friday'                        => 'Fredagen',
	'saturday'                      => 'Lördagen',
	'sunday'                        => 'Söndagen',

	'monday_short'                  => 'M',
	'tuesday_short'                 => 'T',
	'wednesday_short'               => 'O',
	'thursday_short'                => 'T',
	'friday_short'                  => 'F',
	'saturday_short'                => 'L',
	'sunday_short'                  => 'S',

	'first'                         => 'Första',
	'second'                        => 'Andra',
	'third'                         => 'Tredje',
	'fourth'                        => 'Fjärde',
	'last'                          => 'Sista',

	/**
	 * Success / Error
	 */
	'screen_updated_ok'             => 'Bilden har uppdaterats.',
	'screen_updated_fail'           => 'Bilden misslyckades att uppdateras.',
	'repeat_success_updated'        => 'Schemaläggningen har uppdaterats.',
	'unable_to_determ_recur_type'   => 'Unable to determine recurrence type.',
	'screen_group_created_ok'       => 'Område skapat.',

	'drop_files'                    => 'Dra bild hit för att lägga till.',

	/**
	 * Tooltips
	 */
	'tag_tooltip'                   => 'Ange taggar, skilj dem med mellanslag.',
	'screengroup_tooltip'           => 'Markera de områden i vilka bilden skall visas.',

	'event_start_date_tooltip'      => 'Ange start datumn.',
	'event_end_date_tooltip'        => 'Ange slut datumn, om inget angivet schemaläggs den tillsvidare.',
	'event_start_time_tooltip'      => 'Ange start tid.',
	'event_end_time_tooltip'        => 'Ange slut tid.',
	'event_repeat_type_tooltip'     => 'Ange typ av upprepning.',
	'event_frequency_day_tooltip'   => 'Ange antalet dagar mellan varje förekomst.',
	'event_frequency_week_tooltip'  => 'Ange antal veckor mellan varje förekomst',
	'event_frequency_month_tooltip' => 'Ange antal månader mellan varje förekomst.',
	'event_frequency_year_tooltip'  => 'Ange antal år mellan varje förekomst.',
	'event_week_tooltip'            => 'Ange vecka.',
	'event_day_tooltip'             => 'Ange dag.',
	'event_days_ahead_tooltip'      => 'Om ___ skall visas ett viss antal dagar innan förekomst, ange då antal.',

];
