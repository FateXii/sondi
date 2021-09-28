declare type UploadStatus = "ready" | "uploading" | "success" | "fail";
export declare type UploadFile = {
  name: string;
  percentage?: number;
  status: UploadStatus;
  size: number;
  response?: unknown;
  uid: number;
  url?: string;
  raw: ElFile;
};
export interface ElFile extends File {
  uid: number;
}
