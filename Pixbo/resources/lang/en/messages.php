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
    'name'                          => 'Name',
    'desc'                          => 'Description',
    'id'                            => '#',
    'created'                       => 'Created',
    'modified'                      => 'Modified',
    'updated'                       => 'Updated',
    'info'                          => 'Info',
    'image'                         => 'Image',
    'schedule'                      => 'Schedule',
    'scheduled'                     => 'Scheduled',
    'ip_address'                    => 'IP address',
    'summary'                       => 'Summary',
    'text'                          => 'Text',
    'activity'                      => 'Activity',
    'action'                        => 'Action|Actions',
    'upload'                        => 'Upload',
    'preview'                       => 'Preview',
    'choose_file'                   => 'Choose file',
    'cancel'                        => 'Cancel',
    'tag_missing'                   => 'Something is not right, tag missing.',
    'unknown'                       => 'Unknown',
    'offline'                       => 'Offline',
    //'schedule'                    => 'Planering',
    'language'                      => 'Choose language',
    'en'                            => 'English',
    'sv'                            => 'Swedish',
    'no_images'                     => 'No images',

    /**
     * Commonly used words.
     */
    'add'                           => 'Add',
    'close'                         => 'Close',
    'save'                          => 'Save',
    'yes'                           => 'Yes',
    'no'                            => 'No',
    'active'                        => 'Active',
    'settings'                      => 'Settings',
    'edit'                          => 'Edit',
    'remove'                        => 'Remove',

    /**
     * Models
     */

    // MODEL
    'screen_group'                  => 'Screengroup|Screengroups',
    'client'                        => 'Client|Clients',
    'screen'                        => 'Screen|Screens',
    'event'                         => 'Event|Events',
    'user'                          => 'User|Users',
    'ticker'                        => 'Ticker|Tickers',
    'role'                          => 'Role|Roles',
    'tag'                           => 'Tag|Tags',

    // ADD MODEL
    'add_screen'                    => 'Add screen',
    'add_ticker'                    => 'Add ticker',
    'add_screen_group'              => 'Add screengroup',
    'add_user'                      => 'Add user',
    'add_client'                    => 'Add client',

    // SHOW MODEL
    'show_screen_group'             => 'Show screengroup',
    'show_screen'                   => 'Show screen',
    'show_ticker'                   => 'Show ticker',

    // EDIT MODEL
    'edit_screen_group'             => 'Edit screengroup',
    'edit_screen'                   => 'Edit screen',
    'edit_client'                   => 'Edit client',
    'edit_user'                     => 'Edit user',

    /**
     * Time/Date
     */

    'date'                          => 'Date',
    'start'                         => 'Start',
    'end'                           => 'End',
    'day'                           => 'Day',
    'week'                          => 'Week',

    'period'                        => 'Period',

    'recurring'                     => 'Recurring',

    'repeat'                        => 'Repeat:',
    'repeat_every'                  => 'Repeat every:',
    'repeat_each'                   => 'Repeat each:',
    'starts'                        => 'Starts:',
    'ends'                          => 'Ends:',
    'never'                         => 'Never',
    'at'                            => 'At:',
    'the'                           => 'The:',
    'days_before_event'             => 'Show before',

    'start_date'                    => 'Start date',
    'end_date'                      => 'End date',
    'start_time'                    => 'Start time',
    'end_time'                      => 'End time',

    'frequency'                     => 'Frequency',
    'day_frequency'                 => 'Every n:th day',
    'week_frequency'                => 'Every n:th week',
    'month_frequency'               => 'Every n:th month',
    'year_frequency'                => 'Every n:th year',

    'daily'                         => 'Daily',
    'weekly'                        => 'Weekly',
    'monthly'                       => 'Monthly',
    'yearly'                        => 'Yearly',

    'days'                          => 'day(s)',
    'weeks'                         => 'week(s)',
    'months'                        => 'month(s)',
    'years'                         => 'year(s)',

    'each_month'                    => 'each month.',
    'weekdays'                      => 'Days of the week',

    'monday'                        => 'Monday',
    'tuesday'                       => 'Tuesday',
    'wednesday'                     => 'Wednesday',
    'thursday'                      => 'Thursday',
    'friday'                        => 'Friday',
    'saturday'                      => 'Saturday',
    'sunday'                        => 'Sunday',

    'monday_short'                  => 'M',
    'tuesday_short'                 => 'T',
    'wednesday_short'               => 'W',
    'thursday_short'                => 'T',
    'friday_short'                  => 'F',
    'saturday_short'                => 'S',
    'sunday_short'                  => 'S',

    'first'                         => 'First',
    'second'                        => 'Second',
    'third'                         => 'Third',
    'fourth'                        => 'Fourth',
    'last'                          => 'Last',

    /**
     * Success / Error
     */

    // Client
    'client_created_ok'             => 'The client has been created.',
    'client_created_fail'           => 'Failed to create the client, try again.',
    'client_removed_ok'             => 'The client has been removed.',
    'client_removed_fail'           => 'Failed to remove the client, try again.',
    'client_updated_ok'             => 'The client has been updated.',
    'client_updated_fail'           => 'Failed to update the client, try again.',

    // Screen
    'screen_created_ok'             => 'The screen has been created.',
    'screen_created_fail'           => 'Failed to create the screen, try again.',
    'screen_updated_ok'             => 'The screen has been updated.',
    'screen_updated_fail'           => 'Failed to update the screen, try again.',
    'screen_removed_ok'             => 'The screen has been removed.',
    'screen_removed_fail'           => 'Failed to remove the screen, try again.',

    // Screengroup
    'screen_group_created_ok'       => 'Screengroup has been created.',
    'screen_group_created_fail'     => 'Failed to create the screengroup, try again.',

    // Ticker
    'ticker_created_ok'             => 'The ticker has been created.',
    'ticker_created_fail'           => 'Failed to create the ticker, try again.',
    'ticker_updated_ok'             => 'The ticker has been updated.',
    'ticker_updated_fail'           => 'Failed to update the ticker, try again.',

    // User
    'user_created_ok'               => 'The user has been created.',
    'user_created_fail'             => 'Failed to create the user, try again.',

    // Events
    'repeat_success_updated'        => 'The schedule has been updated.',
    'unable_to_determ_recur_type'   => 'Unable to determine recurrence type.',
    'screen_association_removed'    => 'The screen has been removed from :screengroup.',

    'drop_files'                    => 'Drop image here to upload.',

    /**
     * Tooltips
     */

    'screengroup_tooltip'           => 'Select the screengroups you want the screen to be shown in.',

    'event_start_date_tooltip'      => 'Set start date.',

    'event_end_date_tooltip'        => 'Set end date, .',
    'event_start_time_tooltip'      => 'Set start time.',
    'event_end_time_tooltip'        => 'Set end time.',
    'event_repeat_type_tooltip'     => 'Recurrence type.',
    'event_frequency_day_tooltip'   => 'Set number of days between occurences.',
    'event_frequency_week_tooltip'  => 'Set number of weeks between occurences.',
    'event_frequency_month_tooltip' => 'Set number of months between occurences.',
    'event_frequency_year_tooltip'  => 'Set number of years between occurences.',
    'event_week_tooltip'            => 'Set week.',
    'event_day_tooltip'             => 'Set day.',


    'event_days_ahead_tooltip'      => 'Set number of days ahead of occurence to show.',

    'schedule_tooltip'              => 'Schedule',
    'remove_association_tooltip'    => 'Remove from :association',

];
