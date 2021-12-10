
/**
 * Initialise le camembert des discplines
 * @param {RowData[]} lines
 */
function createPieDiscipline(lines) {
  const idLib = 3;
  let res = {
    "Driot prive": 0,
    "Droit international": 0,
    "Droit penal et sciences criminelles": 0,
    "Droit prive": 0,
    "Droit public": 0,
    "Etudes anglophones": 0,
    "Etudes de genre": 0,
    "Etudes germaniques": 0,
    "Etudes hispaniques":0,
    "Etudes hispano-americaines":0,
    "Etudes iberiques et latino americaines":0,
    "Etudes occitanes":0,
    "Geographie":0,
    "Geographie physique":0,
    "Histoire":0,
    "Histoire ancienne":0,
    "Histoire de l'art":0,
    "Histoire des religions":0,
    "Histoire des sciences et des techniques":0,
    "Histoire du droit et des institutions":0,
    "Histoire moderne et contemporaine":0,
    "Informatique":0,
    "Litteratures et civilisations comparees":0,
    "Litteratures francaise et francophone":0,
    "Mathematiques et informatique appliquees aux sciences sociales (miass)":0,
    "Mecanique des solides, des materiaux, des structures et des surfaces":0,
    "Philosophie (metaphysique, epistemologie, esthetique)":0,
    "Psychanalyse":0,
    "Psychologie":0,
    "Science politique":0,
    "Sciences de gestion":0,
    "Sciences de l'education":0,
    "Sciences de l'information et de la communication":0,
    "Sciences du langage":0,
    "Sciences economiques":0,
    "Sociologie":0
  }


  const total = lines.length;
  lines.forEach(rowData => {
    let elem = rowData.row;
    res[elem.children[idLib].innerHTML] += 1;
  });
  let data = [];
  Object.keys(res).forEach(key => {
    if (res[key] !== 0) {
      data.push({
        name: key,
        y: res[key] / total * 100
      })
    }
  })


  // Creation du graphique.
  Highcharts.chart('pie-chart', {
    chart: {
      type: 'pie'
    },
    title: {
      text: 'Discipline'
    },
    subtitle: {
      text: 'Les discplines des thèses obtenus par rapport à la recherche.'
    },
    accessibility: {
      announceNewData: {
        enabled: true
      },
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      series: {
        dataLabels: {
          enabled: true,
          format: '{point.name}: {point.y:.1f}%'
        }
      }
    },
    tooltip: {
      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },
    series: [
      {
        name: "Discplines",
        colorByPoint: true,
        data: data
      }
    ]
  });

}