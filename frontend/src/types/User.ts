export type UserRoles = "Admin" | "Agent" | "Tenant";
export interface IPotentialUserData {
  email: string;
  is_admin: boolean;
  is_agent: boolean;
  is_tenant: boolean;
}
export interface IAbreviatedUser {
  is_agent: boolean;
  phone_number: string;
  agent_registration_number: string;
  bio: string;
  name: string;
  email: string;
}

export interface IUserRoles {
  is_admin: boolean;
  is_agent: boolean;
  is_tenant: boolean;
}
