(function () {
    const speakersInput = document.querySelector('#speakers');

    if(speakersInput) {
        let speakers = [];
        let filteredSpeakers = [];

        const speakersList =  document.querySelector('#speakers-list');
        const speakerHidden = document.querySelector('[name="speaker_id"]');

        getSpeakers();
        speakersInput.addEventListener('input', searchSpeakers)

        if(speakerHidden.value) {
            (async () => {
                const speaker = await getSpeaker(speakerHidden.value);
                const {name, lastname} = speaker;

                //Insert in the HTML
                const speakerDOM = document.createElement('LI');
                speakerDOM.classList.add('speakers-list__speaker' , 'speakers-list__speaker--selected');
                speakerDOM.textContent = `${name} ${lastname}`;

                speakersList.appendChild(speakerDOM);
            })()
        }

        async function getSpeakers() {
            const url = `/api/speakers`;
            const response = await fetch(url);
            const result = await response.json();

            modifySpeakers(result)
        }

        async function getSpeaker(id) {
            const url = `/api/speaker?id=${id}`;
            const response = await fetch(url);
            const result = await response.json();
            return result;
        }

        function modifySpeakers(arraySpeakers = []) {
            speakers = arraySpeakers.map(speaker => {
                return {
                    id : speaker.id,
                    name: `${speaker.name.trim()} ${speaker.lastname.trim()}`,
                }
            })
        }

        function searchSpeakers(e) {
            search = e.target.value;

            if(search.length > 3 ) {
                const expresion = new RegExp(search, "i");
                filteredSpeakers = speakers.filter(speaker => {
                    if(speaker.name.toLowerCase().search(expresion) != -1) {
                        return speaker;
                    }
                })

            } else {
                filteredSpeakers = [];
            }

            showSpeakers(); 
        }

        function showSpeakers() {

            while(speakersList.firstChild) {
                speakersList.removeChild(speakersList.firstChild);
            }

            if(filteredSpeakers.length > 0) {
                filteredSpeakers.forEach(speaker => {
                    const speakerHTML = document.createElement('LI');
                    speakerHTML.classList.add('speakers-list__speaker');
                    speakerHTML.textContent = speaker.name;
                    speakerHTML.dataset.speakerId = speaker.id;
                    speakerHTML.onclick = selectSpeaker;

                    //Add to DOM
                    speakersList.appendChild(speakerHTML);
                })
            } else {
                const noResult = document.createElement('P');
                noResult.classList.add('speakers-list__no-result');
                noResult.textContent = 'There are no results for your search';
                speakersList.appendChild(noResult);
            }
            
        }

        function selectSpeaker(e) {
            const speaker = e.target;

            const previousSpeaker = document.querySelector('.speakers-list__speaker--selected');
            if(previousSpeaker) {
                previousSpeaker.classList.remove('speakers-list__speaker--selected')
            }

            speaker.classList.add('speakers-list__speaker--selected')

            speakerHidden.value = speaker.dataset.speakerId;
        }
    }
})();