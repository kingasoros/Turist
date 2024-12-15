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
