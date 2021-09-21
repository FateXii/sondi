import { ElFile } from "@/interfaces";

declare type UploadStatus = "ready" | "uploading" | "success" | "fail";

declare type UploadFile = {
  name: string;
  percentage?: number;
  status: UploadStatus;
  size: number;
  response?: unknown;
  uid: number;
  url?: string;
  raw: ElFile;
};

export { UploadFile, UploadStatus };
