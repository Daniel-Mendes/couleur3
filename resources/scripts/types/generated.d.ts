declare namespace App.Data {
export type AddressData = {
id: number | null;
street: string;
zip_code: string;
city: string;
country: string;
auditor?: App.Data.UserData | null;
};
export type AnswerData = {
id: number;
auditor: App.Data.UserData;
interaction: App.Data.InteractionData;
};
export type CallToActionData = {
id: number;
link: string;
interaction: App.Data.InteractionData;
};
export type InteractionData = {
id: number;
title: string;
type: App.Enums.InteractionType;
call_to_action: App.Data.CallToActionData | null;
question_choices: Array<App.Data.QuestionChoiceData>;
answers: Array<App.Data.AnswerData>;
animator: App.Data.UserData;
reward: App.Data.RewardData | null;
ended_at: string;
winners_count: number | null;
winners: Array<App.Data.UserData>;
status: App.Enums.InteractionStatus;
};
export type NotificationData = {
type: App.Enums.NotificationType;
body: string;
};
export type QuestionChoiceData = {
id: number;
value: string;
is_correct_answer: boolean;
interaction: App.Data.InteractionData;
};
export type RewardData = {
id: number;
name: string;
description: string;
interactions?: Array<App.Data.InteractionData>;
};
export type SharedData = {
auth: App.Data.UserData | null;
chatEnabled: boolean;
interaction: App.Data.InteractionData | null;
notification: App.Data.NotificationData | null;
};
export type UserData = {
id: number;
name: string;
email: string;
email_verified_at: string;
password: string | null;
};
}
declare namespace App.Enums {
export type InteractionStatus = 'PENDING' | 'STOPPED';
export type InteractionType = 'MCQ' | 'SURVEY' | 'TEXT' | 'AUDIO' | 'VIDEO' | 'PICTURE' | 'CTA' | 'QUICK_CLICK';
export type MediaType = 'AUDIO' | 'VIDEO' | 'PICTURE';
export type NotificationType = 'success' | 'error';
}
