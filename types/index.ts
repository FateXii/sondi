
 interface PropertyImage {
  coverImage: string,
  allImages?: string[],
}

 interface Property  {
  id: number,
  location: string,
  description: string,
  beds:number,
  baths: number,
  garages: number,
  buying: boolean,
  imageList: PropertyImage,
  price:number,
  name:string,
  interested: boolean
}

 interface State {
  list: Property[],
  viewing: number,
  buying: boolean,
  interested: number[]
}

export {
  Property,
  State,
  PropertyImage
}
