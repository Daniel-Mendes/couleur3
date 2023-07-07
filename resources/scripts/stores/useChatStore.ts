import echo from "@/scripts/utils/echo";

export const useChatStore = defineStore("chat", () => {
    const page = usePage();

    const isChatEnabled = ref(page.props.chatEnabled);

    watchEffect(() => {
        isChatEnabled.value = page.props.chatEnabled;
    });

    const messages = ref([] as App.Data.MessageData[]);

    const addMessage = (message: App.Data.MessageData) => {
        messages.value.push(message);
    };

    onMounted(() => {
        subscribeToPublicChannel();
    });

    const subscribeToPublicChannel = () => {
        echo.channel("public")
            .listen("MessageSent", (event) => {
                addMessage(event.message);
            })
            .listen("ChatUpdated", (event) => {
                isChatEnabled.value = event.chatEnabled;
                messages.value = [];
            })
            .error((error) => {
                console.error(error);
            });
    };

    return { isChatEnabled, messages };
});
