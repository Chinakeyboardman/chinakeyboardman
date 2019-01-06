package Paint;

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Point;

class Line
  extends SimpleShape
{
  public Line() {}
  
  public Line(Color paramColor)
  {
    this.color = paramColor;
  }
  
  public Line(Point paramPoint, Color paramColor) {
    this(paramColor);
    this.p1 = paramPoint;
  }
  
  public void draw(Graphics paramGraphics)
  {
    if ((this.p1 == null) || (this.p2 == null)) return;
    Color localColor = paramGraphics.getColor();
    paramGraphics.setColor(this.color);
    paramGraphics.drawLine(this.p1.x, this.p1.y, this.p2.x, this.p2.y);
    paramGraphics.setColor(localColor);
  }
}

