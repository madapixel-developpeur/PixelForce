var myChatApp = angular.module("myChatApp", []);
const applicationName = "pixelforce";
const baseHeadersChatApi = {
    'authorization': 'Bearer ' + document.jwtToken,
    'x-application': applicationName
};

myChatApp.service('chat', function ($http) {
    this.searchUsersChat = async function (search = '', page = 1, nbrPerPage = 10) {
        const response = await $http({
            method: "GET",
            url: "/chatutil/users/search?search=" + search + "&page=" + page + "&nbrPerPage=" + nbrPerPage
        });
        return response.data;
    }

    this.addConversation = async function (data) {
        const response = await $http({
            method: "POST",
            url: `${document.baseUrlChat}/chat/conversation`,
            headers: baseHeadersChatApi,
            data
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

    $scope.setConversationId = function (conversationId) {
        $scope.conversationId = conversationId;
        $scope.changeView('USER');
    }

    $scope.changeView = function (newView) {
        $scope.currentView = newView;
    }


})

myChatApp.controller('chatUserList', function ($scope, chat) {
    $scope.addConversation = function () {
        $scope.$parent.changeView('SEARCH');
    }
})

myChatApp.controller('chatUserSearchList', function ($scope, $q, chat) {
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
                $scope.$apply(() => {
                    $scope.total = result.total;
                    if (newPage == 1) $scope.data = result.data;
                    else $scope.data = [...$scope.data, ...result.data];

                    $scope.page = newPage;
                    $scope.showLoadingMore = ($scope.page + 1 <= Math.ceil($scope.total / $scope.nbrPerPage));
                });
            }).catch(error => console.error(error))
            .finally(() => {
                $scope.$apply(() => {
                    $scope.isLoading = false;
                    $scope.isLoadingMore = false;
                });
            });
    }

    $scope.goBack = function () {
        $scope.$parent.$apply(() => {
            $scope.$parent.changeView('LIST');
        });
    }

    $scope.addConversation = function (user) {
        $scope.isLoading = true;
        chat.addConversation({ inviteeUserId: user.userId })
            .then((result) => {
                $scope.$apply(() => {
                    $scope.$parent.setConversationId(result.id);
                });
            }).catch(error => console.error(error))
            .finally(() => {
                $scope.$apply(() => {
                    $scope.isLoading = false;
                });
            })
    }

    $scope.loadMore = function () {
        $scope.searchPage($scope.page + 1);
    }

    $scope.search = function () {
        $scope.searchPage();
    }
})

