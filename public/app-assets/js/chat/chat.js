var myChatApp = angular.module("myChatApp", []);

myChatApp.service('chat', function ($http) {
    this.searchUsersChat = async function (search = '', page = 1, nbrPerPage = 10) {
        const response = await $http({
            method: "GET",
            url: "/chatutil/users/search?search=" + search + "&page=" + page + "&nbrPerPage=" + nbrPerPage
        });
        return response.data;
    }
});

myChatApp.filter('truncate', function () {
    return function (value, max) {
        if (!value) return '';

        max = parseInt(max, 10);
        if (!max) return value;
        if (value.length <= max) return value;

        value = value.substr(0, max);
        let lastspace = value.lastIndexOf(' ');
        if (lastspace !== -1) {
            //Also remove . and , so its gives a cleaner result.
            if (value.charAt(lastspace - 1) === '.' || value.charAt(lastspace - 1) === ',') {
                lastspace = lastspace - 1;
            }
            value = value.substr(0, lastspace);
        }


        return value + ' ...';
    };
});

myChatApp.controller('chatWidget', function ($scope) {
    $scope.visible = false;
    $scope.currentView = 'LIST'; // in [LIST, USER, SEARCH]
    $scope.conversationId = null;
    $scope.data = [];
    document.querySelector('div[ng-app="myChatApp"]').classList.remove('d-none');
    $scope.toggleChat = function () {
        $scope.visible = !$scope.visible;
    }

})

myChatApp.controller('chatUserList', function ($scope, chat) {
    $scope.addConversation = function () {
        $scope.$parent.currentView = 'SEARCH';
    }
})

myChatApp.controller('chatUserSearchList', function ($scope, chat) {
    $scope.chatSearch = '';
    $scope.isLoading = false;
    $scope.page = 1;
    $scope.nbrPerPage = 10;
    $scope.showLoadingMore = false;
    $scope.isLoadingMore = false;
    $scope.data = [];
    $scope.total = 0;

    $scope.searchPage = function (newPage = 1) {
        if (newPage == 1) $scope.isLoading = true;
        else $scope.isLoadingMore = true;
        chat.searchUsersChat($scope.chatSearch, newPage, $scope.nbrPerPage)
            .then(result => {
                $scope.total = result.total;
                if (newPage == 1) $scope.data = result.data;
                else $scope.data = [...$scope.data, ...result.data];

                $scope.page = newPage;
                $scope.showLoadingMore = ($scope.page + 1 <= Math.ceil($scope.total / $scope.nbrPerPage));
            }).catch(error => console.error(error))
            .finally(() => {
                console.log('finally')
                $scope.isLoading = false;
                $scope.isLoadingMore = false;
                $scope.$apply();
            });
    }

    $scope.goBack = function () {
        $scope.$parent.currentView = 'LIST';
    }

    $scope.addConversation = function (user) {

    }

    $scope.loadMore = function () {
        $scope.searchPage($scope.page + 1);
    }

    $scope.search = function () {
        $scope.searchPage();
    }
})

