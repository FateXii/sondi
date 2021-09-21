export interface ILoginPayload {
  email: string;
  password: string;
}

export interface IRegistrationPayload {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}
