document.addEventListener('DOMContentLoaded', function () {
  // Maximális hosszúság, amit a keréken és a gombon megjelenítünk
  const maxLabelLength = 15;

  // Funkció a szöveg rövidítésére
  const shortenText = (text, maxLength) => text.length > maxLength ? text.substring(0, maxLength) + '...' : text;

  sectors.forEach((sector, index) => {
    const colors = ['#f0f5ea', '#dce7d1', '#c8d9b8', '#b4cc9f', '#a0be86', '#8bb16d', '#769353', '#61763a', '#4c5921', '#374b08'];
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
});

document.getElementById('search').addEventListener('input', function () {
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

// A látványosságok sorrendjének frissítése
function updateAttractionsOrder(selectedName) {
  fetch(`/api/getAttractions?selectedName=${encodeURIComponent(selectedName)}`)
      .then(response => response.json())
      .then(data => {
          const attractionsContainer = document.querySelector('.wheel-box_first');
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

  // AJAX kérés a város szűrésére
  fetch(`/api/getAttractionsByCity?city=${encodeURIComponent(city)}`)
      .then(response => response.json())
      .then(data => {
          const attractionsContainer = document.querySelector('.wheel-box_first');
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
});

function copyToClipboard() {
  var text = document.getElementById("selectedWord").innerText;

  var tempInput = document.createElement("input");
  document.body.appendChild(tempInput);
  tempInput.value = text;  
  tempInput.select();  
  document.execCommand("copy");  

  document.body.removeChild(tempInput);

  alert("Szöveg másolva: " + text);
}
