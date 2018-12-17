    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawtas);
    google.charts.setOnLoadCallback(drawpr);
    
    //Submits the form inmediately after change
    $('.ccf').change(function(){
            $(this).submit();
            });
            
    /*$('#cvf').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        $.post($form.attr('action'), $form.serialize(), function(data) { }, 'json');
    });*/
     
      
    function drawtas() {
      $.ajax({
          url: googlec.g_url,
          type: "POST",
          data: ({c3: googlec.c3, mv: 'tas'}),
          dataType: "json",
      success:(function (jsonDatm) {
      $( "#bgc" ).html("");
       // Create data table out of JSON data loaded from server.
       var tdat = new google.visualization.DataTable(jsonDatm);
       
           
       //Chart format and options
       var formatter = new google.visualization.NumberFormat({groupingSymbol: '', pattern: '#', });
       var formatter2 = new google.visualization.NumberFormat({pattern: '#.#'});
       var options = {pointSize: 3, pointShape: 'circle', legend:'none',  
          hAxis: {gridlines : {count : 7}, format: "#", viewWindowMode: "pretty", title: 'Year'}, trendlines: { 0: {} }, }
        
        formatter.format(tdat, 0);
        formatter2.format(tdat, 1);
       
       options.title = googlec.t['t'];
       options.vAxis = {title: ' \xB0C', viewWindowMode: "pretty"};
       /*else if (googlec.mv === 'pr') {
           options.vAxis = {title: 'mm', viewWindowMode: "pretty"};
       }*/
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ScatterChart(document.getElementById('gctas'));
      chart.draw(tdat, options);
      
      //Show form
      //$('#cvf').css('visibility', 'visible');
    })
}); }

    function drawpr() {
      $.ajax({
          url: googlec.g_url,
          type: "POST",
          data: ({c3: googlec.c3, mv: 'pr'}),
          dataType: "json",
      success:(function (jsonDatm) {
      //$( "#bgc" ).html("");
       // Create data table out of JSON data loaded from server.
       var pdat = new google.visualization.DataTable(jsonDatm);
       
           
       //Chart format and options
       var formatter = new google.visualization.NumberFormat({groupingSymbol: '', pattern: '#', });
       var formatter2 = new google.visualization.NumberFormat({pattern: '#.#'});
       var options = {pointSize: 3, pointShape: 'circle', legend:'none',  
          hAxis: {gridlines : {count : 7}, format: "#", viewWindowMode: "pretty", title: 'Year'}, trendlines: { 0: {} }, }
        
        formatter.format(pdat, 0);
        formatter2.format(pdat, 1);
       
       options.title = googlec.t['p'];
       options.vAxis = {title: 'mm', viewWindowMode: "pretty"};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ScatterChart(document.getElementById('gcpr'));
      chart.draw(pdat, options);
      
      //Show form
      $('#cvf').css('visibility', 'visible');
    })
});

}