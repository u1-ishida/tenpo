function select_category() {

	var function_list = [
		'Active Ingredient',
		'Chelating Agent',
		'Film Former',
		'Moisturizer',
		'Texturizer'];


	var benefit_list = [
		'Anti-Aging',
		'Moisturization',
		'Even Skintone',
		'Skin Brightning',
		'Antioxidant',
		'Stimulate (Blood) Circulation',
		'Anti-Dehydration',
		'Odour Suppression',
		'Anti-Photoaging',
		'Foam Quality Improver',
		'Lift Up'];

	var application_list = [
		'Skin Care',
		'Sun Care',
		'Hair Care',
		'Body Care',
		'Color Cosmetics',
		'Oral Care',
		'Household'];

	cat01 = document.category.cat01;
	index = cat01.selectedIndex;
	val = cat01.value;
	cat02 = document.category.cat02;
	//要素を全て削除
	while(cat02.lastChild) {
		cat02.removeChild(cat02.lastChild);
	}
	if (val == "function") {
		for (var i = 0; i < function_list.length; i++) {
			option = document.createElement('option');
    		option.setAttribute('value', function_list[i]);
    		option.innerHTML = function_list[i];
			cat02.appendChild(option);
		}
	} else if (val == "benefit") {
		for (var i = 0; i < benefit_list.length; i++) {
			option = document.createElement('option');
    		option.setAttribute('value', benefit_list[i]);
    		option.innerHTML = benefit_list[i];
			cat02.appendChild(option);
		}
	} else if (val == "application") {
		for (var i = 0; i < application_list.length; i++) {
			option = document.createElement('option');
    		option.setAttribute('value', application_list[i]);
    		option.innerHTML = application_list[i];
			cat02.appendChild(option);
		}
	}
}
