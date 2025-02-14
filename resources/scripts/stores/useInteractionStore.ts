import echo from "@/scripts/utils/echo";

export const useInteractionStore = defineStore(
    "interaction",
    () => {
        const page = usePage();

        const state = reactive({
            isCreatingInteraction: null,
            hasOpenedNotif: false,
            hasBeenRewarded: null,
            hasAnswerd: false,
            currentInteraction: page.props.interaction as App.Data.InteractionData,
            winnersCount: 1,
            chosedWinners: [] as App.Data.UserData[],
            rewards: page.props.rewards as App.Data.RewardData[],
            chosedReward: null as App.Data.RewardData,
            errors: {},
            pinnedAnswers: [] as App.Data.AnswerData[],
        });

        const notPinnedAnswers = computed(() =>
            state.currentInteraction?.answers.filter((answer) => !state.pinnedAnswers.includes(answer))
        );

        watch(
            () => state.currentInteraction,
            (newValue, oldValue) => {
                if (oldValue) {
                    echo.leaveChannel(`interactions.${oldValue.id}`);
                }

                if (newValue) {
                    subscribeAnimatorToPrivateChannel();
                }
            }
        );

        watch(
            () => page.props.auth as App.Data.UserData,
            (newValue, oldValue) => {
                if (oldValue) {
                    echo.leaveChannel(`auditors.${oldValue.id}`);
                }

                if (oldValue.id === newValue.id) return;

                if (newValue) {
                    if (newValue.roleable_type === "App\\Models\\Animator" && state.currentInteraction) {
                        subscribeAnimatorToPrivateChannel();
                    } else if (newValue.roleable_type === "App\\Models\\Auditor" && state.currentInteraction) {
                        subscribeAuditorToPrivateChannel();
                    }
                }
            }
        );

        watchEffect(() => {
            state.currentInteraction = page.props.interaction as App.Data.InteractionData;
            state.errors = page.props.errors;
        });

        onMounted(() => {
            subscribeToPublicChannel();

            if (!page.props.auth) return;

            if (page.props.auth.roleable_type === "App\\Models\\Animator" && state.currentInteraction) {
                subscribeAnimatorToPrivateChannel();
            } else if (page.props.auth.roleable_type === "App\\Models\\Auditor" && state.currentInteraction) {
                subscribeAuditorToPrivateChannel();
            }
        });

        const subscribeToPublicChannel = () => {
            echo.channel("public")
                .listen("InteractionCreated", (event) => {
                    state.hasOpenedNotif = false;
                    state.hasBeenRewarded = null;
                    state.hasAnswerd = false;
                    state.currentInteraction = event.interaction;
                })
                .listen("InteractionEndedEvent", () => {
                    state.hasOpenedNotif = false;
                    state.hasBeenRewarded = null;
                    state.hasAnswerd = false;
                    state.currentInteraction = null;
                })
                .listen("AnswerQuestionChoiceSubmited", (event) => {
                    state.currentInteraction.answers.push(event.answer);
                })
                .error((error) => {
                    console.error(error);
                });
        };

        const subscribeAnimatorToPrivateChannel = () => {
            echo.private(`interactions.${state.currentInteraction.id}`).listen("AnswerSubmitedToAnimator", (event) => {
                state.currentInteraction.answers.push(event.answer);
            });
        };

        const subscribeAuditorToPrivateChannel = () => {
            echo.private(`auditors.${page.props.auth.id}`).listen("WinnerSentResult", (event) => {
                state.hasBeenRewarded = event.reward;
            });
        };

        const createdInteraction = () => {
            state.isCreatingInteraction = null;
        };

        const creatingInteraction = (type: App.Enums.InteractionType) => {
            state.isCreatingInteraction = type;
        };

        const cancelInteraction = () => {
            state.isCreatingInteraction = null;
        };

        const endInteraction = () => {
            router.post(route("interactions.end", state.currentInteraction.id), {
                preserveScroll: true,
                only: ["interaction"],
                onSuccess: () => {
                    cancelInteraction();
                },
            });
        };

        const addPinned = (answer: App.Data.AnswerData) => {
            state.pinnedAnswers.push(answer);
        };

        const removePinned = (answer: App.Data.AnswerData) => {
            state.pinnedAnswers.splice(state.pinnedAnswers.indexOf(answer), 1);
        };

        const removeWinner = (choseWinner: App.Data.UserData) => {
            state.currentInteraction.winners.splice(state.currentInteraction.indexOf(choseWinner), 1);
        };

        const updatePinnedAsChosedWinners = (chosedWinners: App.Data.UserData[]) => {
            chosedWinners.forEach((choseWinner) => {
                if (!state.chosedWinners.includes(choseWinner)) {
                    state.chosedWinners.push(choseWinner);
                } else {
                    state.chosedWinners.splice(state.chosedWinners.indexOf(choseWinner), 1);
                }
            });
        };

        const updateChosedWinner = (choseWinner: App.Data.UserData) => {
            if (!state.chosedWinners.includes(choseWinner)) {
                state.chosedWinners.push(choseWinner);
            } else {
                state.chosedWinners.splice(state.chosedWinners.indexOf(choseWinner), 1);
            }
        };

        const submitFastest = () => {
            router.post(
                route("interactions.winners.fastest", state.currentInteraction.id),
                {
                    winners_count: state.winnersCount,
                    reward_id: state.chosedReward,
                },
                {
                    preserveScroll: true,
                    only: ["interaction", "errors"],
                    onSuccess: () => {
                        state.winnersCount = 1;
                        state.chosedReward = null;
                    },
                }
            );
        };

        const submitRandom = () => {
            router.post(
                route("interactions.winners.random", state.currentInteraction.id),
                {
                    winners_count: state.winnersCount,
                    reward_id: state.chosedReward,
                },
                {
                    preserveScroll: true,
                    only: ["interaction", "errors"],
                    onSuccess: () => {
                        state.winnersCount = 1;
                    },
                }
            );
        };

        const submitManual = () => {
            router.post(
                route("interactions.winners.confirm", state.currentInteraction.id),
                {
                    winners: state.chosedWinners.map((candidate) => candidate.auditor_id),
                    reward_id: state.chosedReward,
                },
                {
                    preserveScroll: true,
                    only: ["interaction", "errors"],
                    onSuccess: () => {
                        state.winnersCount = 1;
                        state.chosedWinners = null;
                        state.chosedReward = null;
                    },
                }
            );
        };

        return {
            ...toRefs(state),
            notPinnedAnswers,
            createdInteraction,
            creatingInteraction,
            cancelInteraction,
            endInteraction,
            addPinned,
            removePinned,
            removeWinner,
            updatePinnedAsChosedWinners,
            submitFastest,
            submitRandom,
            submitManual,
            updateChosedWinner,
        };
    },
    {
        persist: {
            paths: ["hasOpenedNotif"],
        },
    }
);
