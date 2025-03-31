document.addEventListener('DOMContentLoaded', function () {
  // Maximális hosszúság, amit a keréken és a gombon megjelenítünk
  const maxLabelLength = 15;

  // Funkció a szöveg rövidítésére
  const shortenText = (text, maxLength) => text.length > maxLength ? text.substring(0, maxLength) + '...' : text;

  sectors.forEach((sector, index) => {
    const colors = ['#7b836c', '#7d9067', '#5f714a', '#51623c', '#445331', '#3a4729', '#303c22', '#2b361e', '#232d18', '#1a2b00'];
    sector.color = colors[index % colors.length];
  });

  const rand = (m, M) => Math.random() * (M - m) + m;
  const tot = sectors.length;
  const spinEl = document.querySelector('#spin');
  const ctx = document.querySelector('#wheel').getContext('2d');
  const dia = ctx.canvas.width;
  const rad = dia / 2;
  const PI = Math.PI;
  const TAU = 2 * PI;
  const arc = TAU / sectors.length;

  const friction = 0.991;
  let angVel = 0;
  let ang = 0;

  const getIndex = () => Math.floor(tot - (ang / TAU) * tot) % tot;

  function drawSector(sector, i) {
    const ang = arc * i;
    ctx.save();
    ctx.beginPath();
    ctx.fillStyle = sector.color;
    ctx.moveTo(rad, rad);
    ctx.arc(rad, rad, rad, ang, ang + arc);
    ctx.lineTo(rad, rad);
    ctx.fill();
    ctx.translate(rad, rad);
    ctx.rotate(ang + arc / 2);
    ctx.textAlign = 'right';
    ctx.fillStyle = '#fff';
    ctx.font = 'bold 30px sans-serif';
    ctx.fillText(shortenText(sector.label, maxLabelLength), rad - 10, 10); // Rövidített szöveg a keréken
    ctx.restore();
  }

  function rotate() {
    const sector = sectors[getIndex()];
    ctx.canvas.style.transform = `rotate(${ang - PI / 2}rad)`;
    spinEl.textContent = !angVel ? 'SPIN' : shortenText(sector.label, maxLabelLength); // Rövidített szöveg a gombon
    spinEl.style.background = sector.color;
  }

  function frame() {
    if (!angVel) return;
    angVel *= friction;
    if (angVel < 0.002) angVel = 0;
    ang += angVel;
    ang %= TAU;
    rotate();
  }

  function engine() {
    frame();
    requestAnimationFrame(engine);
  }

  function init() {
    document.querySelector('#selectedWord').textContent = ''; // Ürítjük a kiválasztott szót
    spinEl.disabled = false;

    sectors.forEach(drawSector);
    rotate();
    engine();
    spinEl.addEventListener('click', () => {
      if (!angVel) {
        angVel = rand(0.25, 0.45);
        spinEl.disabled = true;
        document.querySelector('#selectedWord').textContent = ''; // Töröljük a szöveget a kattintás előtt
      }
    });
  }

  init();

  const updateSelectedWord = () => {
    const sector = sectors[getIndex()];
    document.querySelector('#selectedWord').textContent = sector.label; // Itt a teljes név jelenik meg
    spinEl.disabled = false;
  };

  function stopWheel() {
    if (angVel === 0) {
      updateSelectedWord();
    }
  }

  function modifiedFrame() {
    frame();
    stopWheel();
  }

  function engineWithStopCheck() {
    modifiedFrame();
    requestAnimationFrame(engineWithStopCheck);
  }

  function initWithStopCheck() {
    sectors.forEach(drawSector);
    rotate();
    engineWithStopCheck();
  }

  initWithStopCheck();

  // Keresés funkció és AJAX kérés
  const searchInput = document.getElementById('search');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      const query = this.value;

      // AJAX kérés a Laravel API-hoz a kereséshez
      fetch(`/api/search?query=${encodeURIComponent(query)}`)
          .then(response => response.json())
          .then(data => {
              const resultsContainer = document.getElementById('results');
              resultsContainer.innerHTML = '';

              // A találatok megjelenítése
              data.forEach(item => {
                  const li = document.createElement('li');
                  li.textContent = item.name;

                  // Kattintás esemény a találat kiválasztásához
                  li.addEventListener('click', function () {
                      const selectedName = item.name;

                      // AJAX kérés a kiválasztott név mentésére a session-ba
                      fetch('/api/saveSelectedName', {
                          method: 'POST',
                          headers: {
                              'Content-Type': 'application/json',
                              'X-CSRF-TOKEN': '{{ csrf_token() }}',
                          },
                          body: JSON.stringify({ name: selectedName }),
                      })
                      .then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              updateAttractionsOrder(selectedName);
                          }
                      });
                  });

                  resultsContainer.appendChild(li);
              });
          });
    });
  } else {
    console.error('A "search" ID-jú input elem nem található!');
  }

  // A látványosságok sorrendjének frissítése
  function updateAttractionsOrder(selectedName) {
    fetch(`/api/getAttractions?selectedName=${encodeURIComponent(selectedName)}`)
        .then(response => response.json())
        .then(data => {
            const attractionsContainer = document.querySelector('.card-group');
            attractionsContainer.innerHTML = ''; 

            data.forEach(attraction => {
                const card = document.createElement('div');
                card.className = 'card mb-3';
                card.style = 'margin:5px; background-color:#002f3b; color:#fff;';
                card.innerHTML = `
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="http://localhost/Turist/img/${attraction.image || '..'}" alt="${attraction.name}" style="height:100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">${attraction.name}</h5>
                                <p class="card-text">${attraction.description}</p>
                                <p class="card-text"><small class="text-muted">${attraction.address}</small></p>
                                <p class="card-text"><small class="text-muted">${attraction.created_by}</small></p>
                                <p class="card-text"><small class="text-muted">${attraction.city_name}</small></p>
                            </div>
                        </div>
                    </div>
                `;
                attractionsContainer.appendChild(card);
            });
        });
  }

  // Kattintás kívül, hogy eltüntesse a keresési találatokat
  document.addEventListener('click', function (event) {
    const searchInput = document.getElementById('search');
    const resultsContainer = document.getElementById('results');

    if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
        resultsContainer.innerHTML = ''; 
    }
  });

  // Városok lista betöltése
  fetch('/api/cities')
    .then(response => response.json())
    .then(cities => {
        const citySelect = document.getElementById('city');
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    });

// Keresés alkalmazása a szűrőre
document.getElementById('apply-filters').addEventListener('click', function () {
  const city = document.getElementById('city').value;
  const type = document.getElementById('type').value;
  const interest = document.getElementById('interest').value;

  const data = {
      city: city,
      type: type,
      interest: interest,
  };

  console.log('Küldött JSON:', JSON.stringify(data));

  // Szűrt adatok lekérése az adatbázisból
  fetch(`/api/getAttractionsByFilters?city=${encodeURIComponent(city)}&type=${encodeURIComponent(type)}&interest=${encodeURIComponent(interest)}`)
      .then(response => response.json())
      .then(data => {
          const attractionsContainer = document.querySelector('.card-group');
          attractionsContainer.innerHTML = ''; // Az előző találatok törlése

          // Kártyák létrehozása az adatok megjelenítéséhez
          data.forEach(attraction => {
              const card = document.createElement('div');
              card.className = 'card mb-3';
              card.style = 'margin:5px; background-color:#002f3b; color:#fff;';
              card.innerHTML = `
                  <div class="row g-0">
                      <div class="col-md-4">
                          <img src="http://localhost/Turist/img/${attraction.image || '..'}" alt="${attraction.name}" style="height:100%; width:100%;">
                      </div>
                      <div class="col-md-8">
                          <div class="card-body">
                              <h5 class="card-title">${attraction.name}</h5>
                              <p class="card-text">${attraction.description}</p>
                              <p class="card-text"><small class="text-muted">Cím: ${attraction.address}</small></p>
                              <p class="card-text"><small class="text-muted">Készítő: ${attraction.created_by}</small></p>
                              <p class="card-text"><small class="text-muted">Város: ${attraction.city_name}</small></p>
                              <p class="card-text"><small class="text-muted">Típus: ${attraction.type}</small></p>
                              <p class="card-text"><small class="text-muted">Érdeklődés: ${attraction.interest}</small></p>
                          </div>
                      </div>
                  </div>
              `;
              attractionsContainer.appendChild(card);
          });
      })
      .catch(error => console.error('Lekérési hiba:', error));
});


// A látványosságok sorrendjének frissítése
function updateAttractionsOrder(selectedName) {
  const attractionsContainer = document.querySelector('.wheel-box_first');
  const cardGroup = document.querySelector('.card-group'); // Ha van .card-group elem

  // Elrejtjük a .card-group-ot frissítés közben
  if (cardGroup) {
    cardGroup.style.display = 'none';
  }

  fetch(`/api/getAttractions?selectedName=${encodeURIComponent(selectedName)}`)
      .then(response => response.json())
      .then(data => {
        attractionsContainer.innerHTML = '';  // Töröljük az előző látványosságokat

        data.forEach(attraction => {
            const card = document.createElement('div');
            card.className = 'card mb-3';
            card.style = 'margin:5px; background-color:#002f3b; color:#fff;';
            card.innerHTML = `
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="http://localhost/Turist/img/${attraction.image || '..'}" alt="${attraction.name}" style="height:100%; width:100%; object-fit:cover;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">${attraction.name}</h5>
                            <p class="card-text">${attraction.description}</p>
                            <p class="card-text"><small class="text-muted">${attraction.address}</small></p>
                            <p class="card-text"><small class="text-muted">${attraction.created_by}</small></p>
                            <p class="card-text"><small class="text-muted">${attraction.city_name}</small></p>
                        </div>
                    </div>
                </div>
            `;
            attractionsContainer.appendChild(card);
        });

        // Visszaállítjuk a .card-group-ot, miután a frissítés befejeződött
        if (cardGroup) {
          cardGroup.style.display = 'block';
        }
      });
}


  // Kattintás kívül, hogy eltüntesse a keresési találatokat
  document.addEventListener('click', function (event) {
      const searchInput = document.getElementById('search');
      const resultsContainer = document.getElementById('results');
  
      if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
          resultsContainer.innerHTML = '';  // Kiürítjük a találatokat
      }
  });

  //típus kiíratása
  fetch('/api/types')
  .then(response => response.json())
  .then(types => {
      const typeSelect = document.getElementById('type');
      types.forEach(type => {
          const option = document.createElement('option');
          option.value = type;
          option.textContent = type;
          typeSelect.appendChild(option);
  });
});

//érdeklődés kiíratása
fetch('/api/interests')
  .then(response => response.json())
  .then(interests => {
      const interestSelect = document.getElementById('interest');
      interests.forEach(interest => {
          const option = document.createElement('option');
          option.value = interest;
          option.textContent = interest;
          interestSelect.appendChild(option);
  });
});

const toggleButton = document.getElementById("toggle-wheel");
    const wheelBox = document.getElementById("wheel-box_second");

    toggleButton.addEventListener("click", function () {
        if (wheelBox.style.display === "none" || wheelBox.style.display === "") {
            wheelBox.style.display = "block"; 
            toggleButton.textContent = "▲";  
        } else {
            wheelBox.style.display = "none"; 
            toggleButton.textContent = "▼";  
        }
    });

});
