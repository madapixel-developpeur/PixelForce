import {ConversationComponent} from "./components/ConversationComponent";
import {showMessageInstance, updateMenu} from "./helpers/chat_helpers";

$(function() {
    // detecter s'il y a un message
    const chat_newMessage_topic = JSON.parse(document.getElementById("chat-newMessage-topic").textContent);
    const chat_vu_topic = JSON.parse(document.getElementById("chat-vu-topic").textContent);
    const chat_userTyping_topic = JSON.parse(document.getElementById("chat-userTyping-topic").textContent);
    const chat_userStopTyping_topic = JSON.parse(document.getElementById("chat-userStopTyping-topic").textContent);
    const eventNewMessage = new EventSource(chat_newMessage_topic);
    const eventVu = new EventSource(chat_vu_topic);
    const eventUserTyping = new EventSource(chat_userTyping_topic);
    const eventUserStopTyping = new EventSource(chat_userStopTyping_topic);
    const conversationComponent = new ConversationComponent();
    // présence d'un nouveau message
    eventNewMessage.onmessage = async event => {
        const message = JSON.parse(event.data);
        const canal = message.canal;
        const user = message.user;
        // si une instance est ouverte
        let jCanal = $('#canal-'+canal.id);
        jCanal.find('.chat-list-group-messages').append(conversationComponent.getMessage(message));
        // si l'instance n'est pas ouverte
        if(jCanal.length === 0 ) {
          jCanal = await showMessageInstance(canal);
        }
        // mettre en évidence le canal
        conversationComponent.addHighligh(jCanal)
        // mettre à jour le menu
        await updateMenu(canal)
    }

    // quand quelqu'un voit le message
    eventVu.onmessage = async event => {
        const canal = JSON.parse(event.data);
        const dernierMessageItem = $('.chat-list-group-messages>.list-group-item').last();
        const idUserEnvoyeur = parseInt(dernierMessageItem.attr('data-id-user'))
        // si une instance est ouverte et que la personne qui a vu le message n'est pas l'envoyeur
        let jCanal = $('#canal-'+canal.id);
        conversationComponent.clearVu(jCanal)
        if(jCanal.length > 0 && idUserEnvoyeur !== canal.vuPar.user.id ) {
           // todo: mettre un vu
            conversationComponent.addVu(jCanal, canal);
        }
    }

    // quand quelqu'un est en train d'écrire
    eventUserTyping.onmessage = async event => {
        const canal = JSON.parse(event.data);
        conversationComponent.addUserTyping($('.chat-box-container[id="canal-'+canal.id+'"]'), canal.userTyping)
    }
    
    // quand quelqu'un arrete d'écrire
    eventUserStopTyping.onmessage = async event => {
        const canal = JSON.parse(event.data);
        conversationComponent.removeUserTyping($('.chat-box-container[id="canal-'+canal.id+'"]'), canal.userTyping)
    }


});