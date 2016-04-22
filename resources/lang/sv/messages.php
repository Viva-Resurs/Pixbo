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
	'id'                            => '#',
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
	'activity'                      => 'Aktivitet',
	'action'                        => 'Åtgärd|Åtgärder',
	'upload'                        => 'Ladda upp',
	'preview'                       => 'Förhandsvisning',
	'choose_file'                   => 'Välj fil',
	'cancel'                        => 'Avbryt',
	'tag_missing'                   => 'Något är galet, tag saknas.',
	'unknown'                       => 'Okänt',
	'offline'                       => 'Offline',
	//'schedule'                    => 'Planering',
	'language'                      => 'Välj språk',
	'en'                            => 'Engelska',
	'sv'                            => 'Svenska',
	'no_images'						=> 'Inga bilder',

	/**
	 * Commonly used words.
	 */
	'add'                           => 'Lägg till',
	'close'                         => 'Stäng',
	'save'                          => 'Spara',
	'yes'                           => 'Ja',
	'no'                            => 'Nej',
	'active'                        => 'Aktiv',
	'settings'                      => 'Inställningar',
	'edit'                          => 'Redigera',
	'remove'                        => 'Ta bort',

	/**
	 * Models
	 */

	// MODEL
	'screen_group'                  => 'Område|Områden',
	'client'                        => 'Bildskärm|Bildskärmar',
	'screen'                        => 'Bild|Bilder',
	'event'                         => 'Event|Events',
	'user'                          => 'Användare|Användare',
	'ticker'                        => 'Ticker|Tickers',
	'role'                          => 'Roll|Roller',
	'tag'                           => 'Tag|Taggar',

	// ADD MODEL
	'add_screen'                    => 'Lägg till bild',
	'add_ticker'                    => 'Ticker text',
	'add_screen_group'              => 'Lägg till område',
	'add_user'                      => 'Lägg till användare',
	'add_client'                    => 'Lägg till bildskärm',

	// SHOW MODEL
	'show_screen_group'             => 'Visa område',
	'show_screen'                   => 'Visa bild',
	'show_ticker'                   => 'Visa Ticker',

	// EDIT MODEL
	'edit_screen_group'             => 'Redigera område',
	'edit_screen'                   => 'Redigera bild',
	'edit_client'                   => 'Redigera bildskärm',
    'edit_user'                     => 'Redigera användare',

	/**
	 * Time/Date
	 */

	'date'                          => 'Datum',
	'start'                         => 'Start',
	'end'                           => 'Slut',
	'day'                           => 'Dag',
	'week'                          => 'Vecka',

	'period'                        => 'Period',

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

	// Client
	'client_created_ok'             => 'Bildskärmen har lagts till.',
	'client_created_fail'           => 'Misslyckades att skapa skärmen, försök igen.',
	'client_removed_ok'             => 'Bildskärmen togs bort.',
	'client_removed_fail'           => 'Misslyckades att ta bort bildskärmen, försök igen.',
	'client_updated_ok'             => 'Bildskärmen har sparats.',
	'client_updated_fail'           => 'Misslyckades att spara ändringarna, försök igen.',

	// Screen
	'screen_created_ok'             => 'Bilden har laddats upp.',
	'screen_created_fail'           => 'Misslyckades att ladda upp bilden, försök igen.',
	'screen_updated_ok'             => 'Bilden har uppdaterats.',
	'screen_updated_fail'           => 'Bilden misslyckades att uppdateras.',
	'screen_removed_ok'             => 'Bilden togs bort.',
	'screen_removed_fail'           => 'Misslyckades att ta bort bilden.',

	// Screengroup
	'screen_group_created_ok'       => 'Område skapat.',
	'screen_group_created_fail'     => 'Misslyckades att lägga till område.',
	'screen_group_updated_ok'		=> 'Området har uppdaterats.',
	'screen_group_updated_fail'		=> 'Misslyckades att uppdatera området.',

	// Ticker
	'ticker_created_ok'             => 'Tickern har lagt till.',
	'ticker_created_fail'           => 'Misslyckades att lägga till tickern.',
	'ticker_updated_ok'             => 'Tickern har uppdaterats.',
	'ticker_updated_fail'           => 'Misslyckades att uppdatera tickern.',

	// User
	'user_created_ok'               => 'Användaren skapad.',
	'user_created_fail'             => 'Misslyckades att skapa användaren.',

	// Events
	'repeat_success_updated'        => 'Schemaläggningen har uppdaterats.',
	'unable_to_determ_recur_type'   => 'Unable to determine recurrence type.',
	'screen_association_removed'    => 'Bilden togs bort från :screengroup.',

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

    // TODO: fix the tooltip
	'event_days_ahead_tooltip'      => 'Om ___ skall visas ett viss antal dagar innan förekomst, ange då antal.',

	'schedule_tooltip'              => 'Planera',
	'remove_association_tooltip'    => 'Tag bort från :association',

];
