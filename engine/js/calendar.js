var months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
var days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс']
const calendar = document.querySelector('#calendar');

console.table(articlesData);
var dates = articlesData.map(a => new Date(a.date.replace(/ /g,"T")));

var maxDate = new Date(Math.max.apply(null, dates));
var minDate = new Date(Math.min.apply(null, dates));

for (let index = minDate.getMonth(); index <= maxDate.getMonth(); index++) {
    var month = document.createElement('div');
    month.setAttribute('class', 'calendar-month');

    var monthName = document.createElement('div');
    monthName.setAttribute('class', 'calendar-month-name');
    monthName.innerHTML = `${months[index]} ${2022}`;

    var monthDayNames = document.createElement('div');
    monthDayNames.setAttribute('class', 'calendar-month-day-names');

    for (let n = 0; n < 7; n++) {
        var dayName = document.createElement('div');
        dayName.setAttribute('class', 'calendar-month-day-name')        
        dayName.innerHTML = days[n];
        monthDayNames.append(dayName);
    }

    var monthDays = document.createElement('div');
    monthDays.setAttribute('class', 'calendar-month-days');

    var dayOffset = new Date(2022, index, 0).getDay();    

    if (dayOffset > 0) {
        var offsetBlock = document.createElement('div');
        offsetBlock.style.gridColumn = `1 / span ${dayOffset}`;
        monthDays.append(offsetBlock);
    }
    
    var dayCount = new Date(2022, index + 1, 0).getDate();

    for (let d = 1; d <= dayCount; d++) {
        var day = document.createElement('a');
        day.setAttribute('class', 'calendar-month-day')        
        day.innerHTML = d;

        var foundArticles = [];

        articlesData.forEach(article => {
            var articleDate = new Date(article.date.replace(/ /g,"T"));           

            if (articleDate.getMonth() == index && articleDate.getDate() == d) {
                day.classList.add('date-has-articles');

                var format = formatArticleText(article.text);
                var image = format.match(/<img src="(.*?)">/);

                if (image != null) {
                    day.style.backgroundImage = `url(${image[1]})`;
                    day.classList.add('date-has-articles-image');
                }
                
                foundArticles.push(article);
            }            
        });

        if (foundArticles.length == 1) {
            day.href = "post.php?id=" + foundArticles[0].id;
            day.title = foundArticles[0].title;
        }
        else if (foundArticles.length > 1) {
            day.title = foundArticles.map(a => a.title).join(', ');
            day.setAttribute('data-articles-json', JSON.stringify(foundArticles.map(({id, title, text, tags, date}) => ({id, title, date}))));
        }

        monthDays.append(day);
    }

    month.append(monthName);
    month.append(monthDayNames);
    month.append(monthDays);
    calendar.append(month);
}

const calendarArticles = document.getElementById('calendar-articles');
const calendarArticlesDate = document.querySelector('#calendar-articles-date');
const calendarArticlesList = document.querySelector('#calendar-articles-list');

document.querySelectorAll('.date-has-articles[data-articles-json]').forEach(element => {
    element.addEventListener('click', () => {
        var articles = JSON.parse(element.getAttribute('data-articles-json'));

        var d = new Date(articles[0]['date'].replace(/ /g,"T"));   

        calendarArticlesDate.innerHTML = `Список статей за ${months[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
        console.log(articles);
        calendarArticlesList.innerHTML = "";
        articles.forEach(a => {
            calendarArticlesList.innerHTML += `<a href="post.php?id=${a.id}">${a.title}</a>`;
        });
        
        calendarArticles.style.display = calendarArticles.style.display == "none" ? "" : "none";
        calendarArticles.scrollIntoView({
            behavior: 'smooth'
        });
    });
});