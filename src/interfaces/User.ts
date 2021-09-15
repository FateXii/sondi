export type UserRoles = "Admin" | "Agent" | "Tenant";
export interface IPotentialUserData {
  email: string;
  is_admin: boolean;
  is_agent: boolean;
  is_tenant: boolean;
}
