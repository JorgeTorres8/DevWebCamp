import Swal from "sweetalert2";

(function() {
    let events = [];

    const summary = document.querySelector('#record-summary');
    
    if(summary) {
        const eventsButton = document.querySelectorAll('.event__add');
        eventsButton.forEach(button => button.addEventListener('click', selectEvent));

        const registrationForm = document.querySelector('#record');
        registrationForm.addEventListener('submit', submitForm);

        showEvents()

        function selectEvent({target}) {

            //Disable Event
            if(events.length < 5) {
                target.disabled = true;

                events = [...events, {
                    id: target.dataset.id,
                    tittle: target.parentElement.querySelector('.event__name').textContent.trim()
                }]
        
                showEvents();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Maximum 5 events per record',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }

        }

        function showEvents() {

            //Clean HTML

            clearEvents();

            if(events.length > 0) {
                events.forEach( event => {
                    const eventDOM = document.createElement('DIV');
                    eventDOM.classList.add('record__event');

                    const tittle = document.createElement('H3');
                    tittle.classList.add('record__name');
                    tittle.textContent = event.tittle;

                    const deleteButton = document.createElement('BUTTON');
                    deleteButton.classList.add('record__delete');
                    deleteButton.innerHTML = `<i class="fa-solid fa-trash"></i>`;
                    deleteButton.onclick = function() {
                        deleteEvent(event.id);
                    }

                    eventDOM.appendChild(tittle);
                    eventDOM.appendChild(deleteButton);
                    summary.appendChild(eventDOM);
                })
            } else {
                const noRecord = document.createElement('P');
                noRecord.textContent = 'There are no events, add up to 5';
                noRecord.classList.add('record__text');
                summary.appendChild(noRecord);
            }
        }

        function deleteEvent(id) {
            events = events.filter(event => event.id !== id);
            const addButton = document.querySelector(`[data-id="${id}"]`);
            addButton.disabled = false;
            showEvents();
        }

        function clearEvents() {
            while(summary.firstChild) {
                summary.removeChild(summary.firstChild);
            }
        }

        async function submitForm(e) {
            e.preventDefault();

            const giftId = document.querySelector('#gift').value;
            const eventsId = events.map(event => event.id);
            if(eventsId.length === 0 || giftId === '') {
                Swal.fire({
                    title: 'Error',
                    text: 'Choose at least one event and one gift',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return;
            }

            const data =  new FormData();
            data.append('events', eventsId);
            data.append('gift_id', giftId);

            const url = '/finish-registration/conferences'; 
            const response = await fetch(url, {
                method: 'POST',
                body: data
            })
            const result = await response.json();

            if(result.result) {
                Swal.fire(
                    'Successful Registration',
                    'Your conferences/workshops have been stored, we are waiting for you at DevWebCamp',
                    'success'
                ).then(() => location.href = `/ticket?id=${result.token}`);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'There was a error',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            }
        }
    }
})();