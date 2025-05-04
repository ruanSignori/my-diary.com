import { Categories } from "./Categories";

export interface PostView {
  id: number;
  title: string;
  slug: string;
  content: string;
  day_week_created: string;
  created_at: string;
  updated_at: string;
  author_id: number;
  author: string;
  categories: Categories[]
}

export interface PostSimpleView {
  id: number;
  title: string;
  slug: string;
  category: string;
  day_week_created: string;
  created_at: string;
  author: string;
}
