export interface Comment {
  id: number;
  content: string;
  created_at: string;
  deleted_at: string | null;
  user: User;
  parent_id: number | null;
  replies?: Comment[];
}
