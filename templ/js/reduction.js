var width = 380;
var height = 380;
var radius = Math.min(width, height) / 2;
var data = [
{name: '2 %', value: 2},
{name: '3 %', value: 2},
{name: '4 %', value: 2},
{name: '5 %', value: 2},
{name: '6 %', value: 2},
{name: '7 %', value: 2}
];

var svg = d3.select("#pie-chart")
        .append("svg")
            .attr("width", width)
            .attr("height", height);

if(window.innerWidth <= 639) {
  g  = svg.append("g")
            .attr("transform", `translate(150, 150)`);
   } else {
  g  = svg.append("g")
            .attr("transform", `translate(${width / 2}, ${height / 2})`);
  }


window.onresize = function(e) {
   if(e.target.innerWidth <= 639) {
  g  = svg.select("g")
            .attr("transform", `translate(150, 150)`);
   } else {
  g  = svg.select("g")
            .attr("transform", `translate(${width / 2}, ${height / 2})`);
  }
};

var color = ["#d3ebf1", "#c5e4e9","#abdbe6","#84cde0","#59c2d9","#2bb3d0"];

var pie = d3.pie()
        .value(d => d.value)
        .sort(null);

var path= d3.arc()
        .innerRadius(0)
        .outerRadius(radius);

var label= d3.arc()
    .outerRadius(radius - 40)
    .innerRadius(radius - 40);

var arc = g.selectAll(".arc").data(pie(data)).enter().append("g").attr("class", "arc");

arc.append("path").attr("d", path).attr("fill", d => color[d.index]);

arc.append("text").attr("transform", d => `translate(${label.centroid(d)})` ).attr("dy", ".35em").text( d => d.data.name );

function highlightPieArcs() {
    var table = $('.dis-table-origin');
    var higlighted;
    $('#pie-chart').on('mouseover', 'g.arc', function(){
        var text = $(this).find('text').text();
        text = text.trim();
        higlighted = table.find('td:contains('+ text +')');
        higlighted.parent().children().each(function(i, el){
            $(this).css('backgroundColor','#ebebeb');
        });
    });
    $('#pie-chart').on('mouseleave', 'g.arc', function(){
        higlighted.parent().children().each(function(i, el){
            $(this).removeAttr('style');
        });
    });
}

function highlightTable() {
    var table = $('.dis-table-origin');
    var higlighted;
    var text;
    table.on('mouseover', 'tr', function(){
        text = $(this).find('td.dis-table-origin__number').text();
        text = text.trim();
        higlighted = $('#pie-chart').find('text:contains('+ text +')');
        higlighted.parent().css('transform', 'scale(1)');
        $(this).children().each(function(i, el){
            $(this).css('backgroundColor','#ebebeb');
        });
    });
    table.on('mouseleave', 'tr', function(){
        higlighted.parent().removeAttr('style');
        $(this).children().each(function(i, el){
            $(this).removeAttr('style');
        });
    });
}

$(document).ready(function(){
    highlightPieArcs();
    highlightTable();
});