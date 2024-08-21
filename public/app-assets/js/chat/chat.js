var myChatApp = angular.module("myChatApp", ['btford.socket-io']);
const applicationName = "pixelforce";
const baseHeadersChatApi = {
    'authorization': 'Bearer ' + window.jwtToken,
    'x-application': applicationName
};

myChatApp.factory('socket', function (socketFactory) {
    // Custom configuration with extra headers and query parameters
    var myIoSocket = io.connect(window.socketUrlChat, {
        query: {
            token: window.jwtToken,
        },
        extraHeaders: {
            'x-application': applicationName
        }
    });

    return socketFactory({
        ioSocket: myIoSocket
    });
});

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
        return isOnlyTime ? moment(value, 'HH:mm:ss').locale('fr').fromNow() : moment(value).locale('fr').fromNow();
    };
});

myChatApp.controller('chatWidget', function ($scope, socket, chat) {
    $scope.visible = false;
    $scope.currentView = null; // in [LIST, USER, SEARCH]
    $scope.conversationId = null;
    $scope.data = [];
    document.querySelector('div[ng-app="myChatApp"]').classList.remove('d-none');
    $scope.userId = window.userId;
    $scope.toggleChat = function () {
        $scope.visible = !$scope.visible;
        if ($scope.visible) {
            $scope.changeView('LIST');
        } else {
            $scope.changeView(null);
        }
    }

    $scope.fetchData = function () {
        chat.findConversationNotViewedCount()
            .then(result => {
                $scope.$apply(() => {
                    $scope.data = result;
                });
            }).catch(error => console.error(error))

    }

    $scope.setConversationId = function (conversationId) {
        $scope.conversationId = conversationId;
        console.log('$scope.conversationId', $scope.conversationId)
        $scope.changeView('USER');
    }

    $scope.changeView = function (newView) {
        $scope.currentView = newView;
        $scope.$broadcast('changeView', { currentView: $scope.currentView });
    }

    $scope.viewConversationGlobal = function (conversationId) {
        $scope.$broadcast('viewConversationGlobal', { conversationId });
        const tempData = $scope.data;
        const conversationIndex = tempData.findIndex((conversation) => conversation.id == conversationId);
        if (conversationIndex >= 0) {
            tempData.splice(conversationIndex, 1);
        }
        $scope.data = [...tempData];
    }

    socket.on('connect', function () {
        console.log('Connected to server');
    });

    socket.on('disconnect', function () {
        console.log('Disconnected from server');
    });

    socket.on('reconnect', function () {
        console.log('Reconnected to server');
    });

    socket.on('new-message', (data) => {
        chat.findMessageById(data.messageId).then(result => {
            $scope.$apply(() => {
                $scope.$broadcast('newMessage', { message: result });
                const conversationIndex = $scope.data.findIndex((conversation) => conversation.id == result.conversationId);

                if (conversationIndex < 0) {
                    $scope.data = [...$scope.data, result.conversation];
                }

            });
        }).catch(error => console.error(error))

    });

    $scope.fetchData();

})

myChatApp.controller('chatUserList', function ($scope, chat) {
    $scope.isLoading = false;
    $scope.page = 1;
    $scope.nbrPerPage = 10;
    $scope.showLoadingMore = false;
    $scope.isLoadingMore = false;
    $scope.data = [];
    $scope.total = 0;
    console.log('hereeeeeeeeeeee')
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

    $scope.$on('changeView', function (event, data) {
        if (data.currentView == 'LIST') $scope.fetchData();
    });

    $scope.$on('newMessage', function (event, data) {
        if ($scope.$parent.currentView == 'LIST') {


            const tempData = $scope.data;
            const conversationIndex = tempData.findIndex((conversation) => conversation.id == data.message.conversationId);

            if (conversationIndex >= 0) {
                tempData.splice(conversationIndex, 1);
            }
            tempData.unshift(data.message.conversation);
            $scope.data = [...tempData];
        }
    });



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
        $scope.$parent.changeView('LIST');
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

    $scope.$on('changeView', function (event, data) {
        if (data.currentView == 'SEARCH') $scope.searchPage();
    });
})

myChatApp.controller('chatUser', function ($scope, $q, chat) {
    const vm = this;
    $scope.isLoading = false;
    $scope.page = 1;
    $scope.nbrPerPage = 10;
    $scope.showLoadingMore = false;
    $scope.isLoadingMore = false;
    $scope.data = [];
    $scope.total = 0;
    $scope.isHeaderLoading = false;
    $scope.conversation = null;
    vm.message = '';
    $scope.isSending = false;

    $scope.$on('newMessage', function (event, data) {
        if ($scope.$parent.currentView == 'USER' && $scope.$parent.conversationId == data.message.conversationId) {
            $scope.addMessage(data.message);
            $scope.viewConversation();
        }
    });

    $scope.viewConversation = function () {

        chat.viewConversation($scope.$parent.conversationId, new Date())
            .then(() => {
                $scope.$apply(() => {
                    $scope.$parent.viewConversationGlobal($scope.$parent.conversationId);
                });
            }).catch(error => console.error(error));
    }

    $scope.scrollToBottom = function () {
        document.getElementById('bottom').scrollIntoView({ behavior: 'smooth', block: 'end' });
        // $([document.documentElement, document.body]).animate({
        //     scrollTop: $("#bottom").offset().top
        // }, 2000);
    }
    $scope.addMessage = function (message) {
        $scope.data = [message, ...$scope.data];
        $scope.scrollToBottom()
    }

    $scope.onSubmit = function () {
        console.log("message ===" + vm.message)
        console.log('onsubmit', JSON.stringify(vm.message))
        if (!vm.message?.trim()) {
            return
        }
        $scope.isSending = true;
        chat.sendMessage($scope.$parent.conversationId, { content: vm.message })
            .then(result => {
                $scope.$apply(() => {
                    vm.message = '';
                    $scope.addMessage(result);
                });
            }).catch(error => console.error(error))
            .finally(() => {
                $scope.$apply(() => {
                    $scope.isSending = false;
                });
            });
    }

    $scope.fetchConversation = function () {
        $scope.isHeaderLoading = true;
        chat.findConversationById($scope.$parent.conversationId)
            .then(result => {
                $scope.$apply(() => {
                    $scope.conversation = result;
                });
            }).catch(error => console.error(error))
            .finally(() => {
                $scope.$apply(() => {
                    $scope.isHeaderLoading = false;
                });
            });
    }

    $scope.fetchData = function (newPage = 1) {
        if (newPage == 1) $scope.isLoading = true;
        else $scope.isLoadingMore = true;
        const httpParams = chat.flattenObject({
            pagination: { page: newPage, nbrPerPage: $scope.nbrPerPage },
            sort: [{ property: 'createdAt', order: 'DESC' }],
            filter: {}
        });
        chat.findConversationMessages($scope.$parent.conversationId, httpParams)
            .then(result => {
                $scope.$apply(() => {
                    $scope.total = result.count;
                    if (newPage == 1) $scope.data = result.data;
                    else $scope.data = [...$scope.data, ...result.data];

                    $scope.page = newPage;
                    $scope.showLoadingMore = ($scope.page + 1 <= Math.ceil($scope.total / $scope.nbrPerPage));
                    console.log($scope.data);
                });
                if (newPage == 1) {
                    $scope.viewConversation();
                }
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

    $scope.goBack = function () {
        $scope.$parent.changeView('LIST');
    }

    $scope.isConversationCreator = function () {
        return $scope.conversation?.createdByUser?.userIdApplication == window.userId;
    }

    $scope.$on('changeView', function (event, data) {
        if (data.currentView == 'USER') {
            $scope.fetchConversation();
            $scope.fetchData();
        }
    });
})

