
        const searchInput = document.getElementById('search');
        const resultsList = document.getElementById('results');

        searchInput.addEventListener('input', async function () {
            const query = searchInput.value;

            if (query.length < 3) {
                resultsList.innerHTML = '';
                return;
            }

            const response = await fetch(`/search?query=${query}`);
            const results = await response.json();

            resultsList.innerHTML = results.map(result => `<li>${result.name}</li>`).join('');
        });

        document.getElementById('search').addEventListener('input', function(event) {
        var query = event.target.value;

        if (query.length >= 3) {  // Csak akkor keresünk, ha legalább 3 karaktert beírtak
            fetch('/search?query=' + query)  // A 'query' paraméter átadása a kereséshez
                .then(response => response.json())  // JSON válasz
                .then(data => {
                    var resultsContainer = document.getElementById('results');
                    resultsContainer.innerHTML = '';  // Eredmények törlése előző keresés után

                    data.forEach(function(item) {
                        var li = document.createElement('li');
                        li.textContent = item.name;  // Az adatbázisban található 'name' mező
                        resultsContainer.appendChild(li);
                    });
                })
                .catch(error => console.error('Hiba történt:', error));
        }
    });
