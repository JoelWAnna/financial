function jsDateSelector(selectbox, tNumb)
{
	var m = "month" + tNumb;
	var monthDD = document.getElementById(m);
	var month = parseInt(monthDD.options[monthDD.selectedIndex].value);
	var y = "year" + tNumb;
	var yearDD = document.getElementById(y);
	var year = parseInt(yearDD.options[yearDD.selectedIndex].text);
	var d = "day" + tNumb;
	var dateDD = document.getElementById(d);

	var leapYear = (year%100) && !(year%4);
	var i = dateDD.options.length;

	var max = 28;
	switch ( month)
	{
	case 2:
		if(leapYear) max++;
		break;
	case 4: case 6: case 9: case 11:
		max = 30;
		break;
	default:
		max = 31;
		break;
	}
	console.log("case " + max);
	while(i > max)
	{
		i--;
		if (i == parseInt(dateDD.options[dateDD.selectedIndex].value))
		{
			dateDD.selectedIndex--;
		}
		dateDD.remove(i);
	}
	while(i < max)
	{
		i++;
		dateDD.options[dateDD.options.length] = new Option(i,i);
	}
};