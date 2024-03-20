    const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December'
    ];
    const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    function app() {
        return {
            month: '',
            year: '',
            no_of_days: [],
            blankdays: [],
            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

            events: [{
                    event_date: new Date(2024, 3, 1),
                    event_title: "April Fool's Day",
                    event_time: "12:00", // Example time
                    event_theme: 'blue'
                },
                {
                    event_date: new Date(2020, 3, 10),
                    event_title: "Birthday",
                    event_time: "18:00", // Example time
                    event_theme: 'red'
                },
                {
                    event_date: new Date(2020, 3, 16),
                    event_title: "Upcoming Event",
                    event_time: "09:30", // Example time
                    event_theme: 'green'
                }
            ],
            event_title: '',
            event_date: '',
            event_time: '',
            event_theme: 'blue',

            themes: [{
                    value: "blue",
                    label: "Blue Theme"
                },
                {
                    value: "red",
                    label: "Red Theme"
                },
                {
                    value: "yellow",
                    label: "Yellow Theme"
                },
                {
                    value: "green",
                    label: "Green Theme"
                },
                {
                    value: "purple",
                    label: "Purple Theme"
                }
            ],

            openEventModal: false,

            initDate() {
                let today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
            },

            isToday(date) {
                const today = new Date();
                const d = new Date(this.year, this.month, date);
                return today.toDateString() === d.toDateString() ? true : false;
            },

            showEventModal(dateObj) {
                // open the modal
                this.openEventModal = true;
                const selectedDate = new Date(Date.UTC(this.year, this.month, dateObj.day));
                const isoDate = selectedDate.toISOString().split('T')[0];
                this.event_date = isoDate; // Set the selected date with correct time zone
                this.event_time = ""; // Reset time
            },




            addEvent() {
                if (this.event_title == '' || this.event_date == '' || this.event_time == '') {
                    return;
                }

                this.events.push({
                    event_date: this.event_date,
                    event_title: this.event_title,
                    event_time: this.event_time,
                    event_theme: this.event_theme
                });

                console.log(this.events);

                // clear the form data
                this.event_title = '';
                this.event_date = '';
                this.event_time = '';
                this.event_theme = 'blue';

                //close the modal
                this.openEventModal = false;
            },

            getNoOfDays() {
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let today = new Date();
                let currentMonth = today.getMonth();
                let currentYear = today.getFullYear();
                let currentDay = today.getDate();

                // find where to start calendar day of week
                let dayOfWeek = new Date(this.year, this.month).getDay();
                let blankdaysArray = [];
                for (let i = 1; i <= dayOfWeek; i++) {
                    blankdaysArray.push({
                        day: '',
                        disabled: true
                    });
                }

                let daysArray = [];
                for (let i = 1; i <= daysInMonth; i++) {
                    let isDisabled = false;
                    if (
                        this.year < currentYear ||
                        (this.year === currentYear && this.month < currentMonth) ||
                        (this.year === currentYear && this.month === currentMonth && i < currentDay)
                    ) {
                        isDisabled = true;
                    }
                    daysArray.push({
                        day: i,
                        disabled: isDisabled
                    });
                }

                this.blankdays = blankdaysArray;
                this.no_of_days = daysArray;
            },

            openEventDetailsModal: false,
            selectedEvent: {},

            runIt(event) {
                this.selectedEvent = event;
                this.openEventDetailsModal = true;
            },

            date_formatted(date) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return new Date(date).toLocaleDateString(undefined, options);
            },

        }
    }