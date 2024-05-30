export class Cart {
  constructor(public id:number,public user_id:number,public price:string,public product_id:number,
    public quantity:number
  ){}
}


export interface ApiResponse {
  status: number;
  msg: string;
  data: Cart[];
}
