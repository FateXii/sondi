export function onWindowScroll(e: any) {
  let contactWidth = Number();
  const propertyDetailContainer =
    document.getElementsByClassName("property")[0];
  const propertyContactInfo = document.getElementsByClassName("contact")[0];
  const {
    width,
    top: contactTop,
    bottom: contactBottom,
  } = propertyContactInfo.getBoundingClientRect();
  contactWidth = Math.max(width, contactWidth);
  const {
    top,
    right,
    bottom: propertyBottom,
  } = propertyDetailContainer.getBoundingClientRect();
  const fixedPos = 200;
  if (
    top <= fixedPos &&
    Math.round(contactBottom) < Math.round(propertyBottom) &&
    contactTop >= fixedPos
  ) {
    if (propertyContactInfo) {
      propertyContactInfo.setAttribute(
        "style",
        `top:${fixedPos}px;` +
          `position:fixed;` +
          `left:calc(1rem + ${right}px);` +
          `width:${contactWidth}px;`
      );
    }
  } else if (top <= fixedPos && contactTop < fixedPos) {
    propertyContactInfo.setAttribute("style", `align-self:end;`);
  } else {
    propertyContactInfo.setAttribute("style", ``);
  }
}
