(function() { //736

    const hours = document.querySelector('#hours');

    if(hours) {
        const category = document.querySelector('[name="category_id"]');
        const days = document.querySelectorAll('[name="day"]');
        const inputHiddenDay = document.querySelector('[name="day_id"]');
        const inputHiddenHour = document.querySelector('[name="hour_id"]'); //740

        category.addEventListener('change', searchTerm);
        days.forEach(day => day.addEventListener('change', searchTerm));

        let search = { //mod 753
            category_id: +category.value || '',
            day: +inputHiddenDay.value || ''
        }

        if(!Object.values(search).includes('')) { //753

            (async () => {
                await searchEvents();
                const id = inputHiddenHour.value;

                //highlight current time
                const selectedHour = document.querySelector(`[data-hour-id="${id}"]`);
                selectedHour.classList.remove('hours__hour--disabled');
                selectedHour.classList.add('hours__hour--selected');

                selectedHour.onclick = selectTime;
            })();

        }

        function searchTerm(e) {
            search[e.target.name] = e.target.value;
            // reset hidden fields and time picker 744
            inputHiddenHour.value='';
            inputHiddenDay.value='';

            const previousHour = document.querySelector('.hours__hour--selected');
            if(previousHour) {
                previousHour.classList.remove('hours__hour--selected');
            }

            if(Object.values(search).includes('')) { //739
                return
            }

            searchEvents();
        }

        async function searchEvents() {

            const {category_id, day} = search;

            const url = `/api/events-schedules?day_id=${day}&category_id=${category_id}`;
            const result = await fetch(url);
            const events = await result.json();

            //console.log(events); 742 para probar tuvimos que crear un fila en Table+
            getAvailableHours(events); //740
        }

        function getAvailableHours(events) { //740

            //reset hours 744
            const listHours = document.querySelectorAll('#hours li');
            listHours.forEach( li => li.classList.add('hours__hour--disabled'))

            //check elements already taken and remove the variable "disabled" //742
            const hoursTaken = events.map(event => event.hour_id);

            const listHoursArray = Array.from(listHours); //743

            const result =  listHoursArray.filter(li => !hoursTaken.includes(li.dataset.hourId));
            result.forEach( li => li.classList.remove('hours__hour--disabled'));

            const availableHours = document.querySelectorAll('#hours li:not(.hours__hour--disabled)');
            availableHours.forEach(hour => hour.addEventListener('click', selectTime));
        }

        function selectTime(e) {

            //disable previous hour if there is one
            const previousHour = document.querySelector('.hours__hour--selected');
            if(previousHour) {
                previousHour.classList.remove('hours__hour--selected');
            }

            //Add "selected" class
            e.target.classList.add('hours__hour--selected'); //741
            inputHiddenHour.value = e.target.dataset.hourId;

            //744 Fill in the hidden day field
            inputHiddenDay.value = document.querySelector('[name="day"]:checked').value;
        }
    }
})();