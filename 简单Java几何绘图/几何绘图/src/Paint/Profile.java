package Paint;

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Point;
import java.util.ArrayList;
import java.util.Iterator;

class Profile
  extends SimpleShape
{
  private ArrayList<Point> points = new ArrayList();
  
  public Profile() {}
  
  public Profile(Color paramColor) { this.color = paramColor; }
  
  public Profile(Point paramPoint, Color paramColor)
  {
    this(paramColor);
    this.points.add(paramPoint);
  }
  
  public void setP1(Point paramPoint)
  {
    this.points.add(0, paramPoint);
  }
  
  public void setP2(Point paramPoint)
  {
    this.points.add(paramPoint);
  }
  
  public void draw(Graphics paramGraphics)
  {
    if (this.points.size() < 2) return;
    Color localColor = paramGraphics.getColor();
    paramGraphics.setColor(this.color);
    Iterator localIterator = this.points.iterator();
    Object localObject1 = null;Object localObject2 = null;
    while (localIterator.hasNext())
    {
      Point localPoint = (Point)localIterator.next();
      if (localObject1 == null)
      {
        localObject1 = localPoint;
      }
      else
      {
        if (localObject2 == null)
        {
          localObject2 = localPoint;
        }
        else
        {
          localObject1 = localObject2;
          localObject2 = localPoint;
        }
        paramGraphics.drawLine(localObject1.x, localObject1.y, localObject2.x, localObject2.y);
      }
    }
    paramGraphics.setColor(localColor);
  }
}
