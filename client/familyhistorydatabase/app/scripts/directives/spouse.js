'use strict';

app.directive('spouse', ['business', function (Business) {
  return {
    templateUrl: 'views/individual/spouseTemplate.html',
    scope: {
      individual: '=',
      ngModel: '=',
      callback: '&'
    },
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
      Business.individual.getSpouses(scope.ngModel.id, scope.individual).then(function(result){
        if (result) {
          console.log('result', result);
          
          if (result.year && result.year !=='')
          {
            var dateString = '';
            dateString = dateString + ((result.month && result.month !== '')? result.month : '1');
            dateString = dateString + '-' + ((result.day && result.day !== '')? result.day : '1');
            dateString = dateString + '-' + ((result.year)? result.year : '1700');
            scope.ngModel.marriageDate = new Date(dateString);
            console.log('ngModel.marriagedate', scope.ngModel.marriageDate);
          }
          if (result.yearM ===  '1' || result.yearM === 'true')
          {
            scope.ngModel.exactMarriageDate = true;
          }

          Business.individual.getPlace(result.place).then(function(place){
            console.log('place', place);
            scope.ngModel.marriagePlace = place;
          });
        }
      });
    }
  };
}]);
