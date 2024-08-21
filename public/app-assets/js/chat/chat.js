var myChatApp = angular.module("myChatApp", []);
const applicationName = "pixelforce";
const baseHeadersChatApi = {
    'authorization': 'Bearer ' + window.jwtToken,
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
            url: `${window.baseUrlChat}/chat/conversation`,
            headers: baseHeadersChatApi,
            data
        });
        return response.data;
    }

    this.findConversations = async function (params) {
        const url = `${window.baseUrlChat}/chat/conversation`;
        const response = await $http({
            method: "GET",
            url,
            headers: baseHeadersChatApi,
            params
        });
        return response.data;
    }

    this.findConversationById = async function (conversationId) {
        const url = `${window.baseUrlChat}/chat/conversation/${conversationId}`;
        const response = await $http({
            method: "GET",
            url,
            headers: baseHeadersChatApi,
        });
        return response.data;
    }

    this.findConversationNotViewedCount = async function () {
        const url = `${window.baseUrlChat}/chat/conversation/not-viewed/count`;
        const response = await $http({
            method: "GET",
            url,
            headers: baseHeadersChatApi,
        });
        return response.data;
    }

    this.findMessageById = async function (messageId) {
        const url = `${window.baseUrlChat}/chat/message/${messageId}`;
        const response = await $http({
            method: "GET",
            url,
            headers: baseHeadersChatApi,
        });
        return response.data;
    }

    this.findConversationMessages = async function (conversationId, params) {
        const url = `${window.baseUrlChat}/chat/conversation/${conversationId}/message`;
        const response = await $http({
            method: "GET",
            url,
            headers: baseHeadersChatApi,
            params
        });
        return response.data;
    }

    this.sendMessage = async function (conversationId, message) {
        const url = `${window.baseUrlChat}/chat/conversation/${conversationId}/message`;
        const response = await $http({
            method: "POST",
            url,
            headers: baseHeadersChatApi,
            data: message
        });
        return response.data;
    }

    this.viewConversation = async function (conversationId, lastViewDate) {
        const url = `${window.baseUrlChat}/chat/conversation/${conversationId}/view`;
        const response = await $http({
            method: "PATCH",
            url,
            headers: baseHeadersChatApi,
            data: { lastViewDate }
        });
        return response.data;
    }

    this.flattenObjectWithResult = function (
        result,
        obj,
        parentKey = null
    ) {
        if (typeof obj === 'object' && obj !== null) {
            Object.keys(obj).forEach((key) => {
                const newParentKey = parentKey === null ? key : `${parentKey}[${key}]`;
                this.flattenObjectWithResult(result, obj[key], newParentKey);
            });
        } else if (parentKey) {
            result[parentKey] = obj;
        }
    }

    this.flattenObject = function (obj) {
        const result = {};
        this.flattenObjectWithResult(result, obj);
        return result;
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

myChatApp.filter('myTimeAgo', function () {
    return function (value, isOnlyTime = false) {
        return isOnlyTime ? moment(value, 'HH:mm:ss').fromNow() : moment(value).fromNow();
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
    $scope.isLoading = false;
    $scope.page = 1;
    $scope.nbrPerPage = 10;
    $scope.showLoadingMore = false;
    $scope.isLoadingMore = false;
    $scope.data = [];
    $scope.total = 0;
    $scope.addConversation = function () {
        $scope.$parent.changeView('SEARCH');
    }

    $scope.fetchData = function (newPage = 1) {
        if (newPage == 1) $scope.isLoading = true;
        else $scope.isLoadingMore = true;
        const httpParams = chat.flattenObject({
            pagination: { page: newPage, nbrPerPage: $scope.nbrPerPage },
            sort: [{ property: 'coalesce(lastMessage.createdAt, conversation.createdAt)', order: 'DESC' }],
            filter: {}
        });
        chat.findConversations(httpParams)
            .then(result => {
                $scope.$apply(() => {
                    $scope.total = result.count;
                    if (newPage == 1) $scope.data = result.data;
                    else $scope.data = [...$scope.data, ...result.data];

                    $scope.page = newPage;
                    $scope.showLoadingMore = ($scope.page + 1 <= Math.ceil($scope.total / $scope.nbrPerPage));
                    console.log($scope.data);
                });
            }).catch(error => console.error(error))
            .finally(() => {
                $scope.$apply(() => {
                    $scope.isLoading = false;
                    $scope.isLoadingMore = false;
                });
            });
    }

    $scope.loadMore = function () {
        $scope.fetchData($scope.page + 1);
    }

    $scope.conversationSelected = function (conversationIdSelected) {
        $scope.$parent.setConversationId(conversationIdSelected);
    }

    $scope.isConversationCreator = function (conversation) {
        return conversation.createdByUser?.userIdApplication == window.userId;
    }
    $scope.isNewMessage = function (conversation) {
        const lastUserView = $scope.isConversationCreator(conversation) ? conversation.lastUser1View : conversation.lastUser2View;
        if (!conversation.lastMessage) return false;
        return !lastUserView || lastUserView < conversation.lastMessage.createdAt;
    }

    $scope.fetchData();
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

