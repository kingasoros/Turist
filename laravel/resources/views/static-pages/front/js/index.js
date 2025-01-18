// // Az aszinkron eseménykezelő, amit megtartunk
// searchInput.addEventListener('input', async function () {
//     const query = searchInput.value;

//     if (query.length < 3) {
//         resultsList.innerHTML = '';
//         return;
//     }

//     try {
//         const response = await fetch(`/search?query=${query}`);
//         const results = await response.json();

//         // A keresési eredmények kiírása
//         resultsList.innerHTML = results.map(result => `<li>${result.name}</li>`).join('');
//     } catch (error) {
//         console.error('Hiba történt a keresési eredmények betöltésekor:', error);
//     }
// });

// // Az alábbi eseménykezelőt eltávolítjuk, mert redundáns:
// document.getElementById('search').addEventListener('input', function(event) {
//     var query = event.target.value;

//     if (query.length >= 3) {  
//         fetch('/search?query=' + query) 
//             .then(response => response.json())  
//             .then(data => {
//                 var resultsContainer = document.getElementById('results');
//                 resultsContainer.innerHTML = ''; 

//                 data.forEach(function(item) {
//                     var li = document.createElement('li');
//                     li.textContent = item.name;  
//                     resultsContainer.appendChild(li);
//                 });
//             })
//             .catch(error => console.error('Hiba történt:', error));
//     }
// });
